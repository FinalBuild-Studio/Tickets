<?php

namespace App\Http\Controllers;

use Mail;
use App\Order;
use App\Mail\OrderConfirmed;
use App\Exceptions\GeneralException;
use Illuminate\Http\Request;

class PayController extends Controller
{

    public function index($reference)
    {
        $order = Order::where('reference', $reference)
            ->where('status', Order::INITIAL)
            ->where('amount', '>', 0)
            ->firstOrFail();

        return view('pay.show', compact('order'));
    }

    public function store(Request $request, $reference)
    {
        $order = Order::where('reference', $reference)
            ->where('status', Order::INITIAL)
            ->lockForUpdate()
            ->firstOrFail();

        $name  = $request->input('name');
        $email = $request->input('email');

        $oldOrder = Order::where('event_id', $order->event->id)
            ->where('email', $email)
            ->whereIn('status', [Order::PAID, Order::CONFIRM])
            ->first();

        if ($oldOrder) {
            throw new GeneralException(403, '不得多次購買');
        }

        $order->name  = $name;
        $order->email = $email;

        if ($order->amount) {
            // Save it before redrecting you to another action
            $order->save();

            // Goto payment page(js redirect)
            return redirect()
                ->action('PayController@index', $reference);
        } else {
            // redrect to confirm page
            $order->status = Order::PAID;
            $order->save();

            Mail::to($order->email)->queue(new OrderConfirmed($order));

            return redirect()
                ->action('ConfirmController@index', $reference);
        }
    }
}
