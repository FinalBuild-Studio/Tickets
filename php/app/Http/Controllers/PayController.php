<?php

namespace App\Http\Controllers;

use Mail;
use App\Order;
use App\Mail\OrderConfirmed;
use Illuminate\Http\Request;

class PayController extends Controller
{

    public function index($reference)
    {
        $order = Order::where('reference', '=', $reference)
            ->where('status', '=', Order::INITIAL)
            ->where('amount', '>', 0)
            ->firstOrFail();

        return view('pay.show', compact('order'));
    }

    public function store(Request $request, $reference)
    {
        $order = Order::where('reference', '=', $reference)
            ->where('status', '=', Order::INITIAL)
            ->lockForUpdate()
            ->firstOrFail();

        $name  = $request->input('name');
        $email = $request->input('email');

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
