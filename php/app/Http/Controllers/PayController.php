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

        $name             = $request->input('name');
        $email            = $request->input('email');
        $invitation       = $request->input('invitation');
        $relatedReference = $request->input('reference');

        if ($order->is_sponsor && $invitation != $order->event->invitation_code) {
            throw new GeneralException(403, '請輸入正確的邀請碼');
        }

        $relatedEvents = $order->event->related_event_ids;
        if ($relatedReference && $relatedEvents) {
            $relatedOrder = Order::whereIn('event_id', json_decode($relatedEvents, true))
                ->where('reference', $relatedReference)
                ->first();

            if (!$relatedOrder) {
                throw new GeneralException(403, '找不到已報名資料');
            }

            $order->related_order_id = $relatedOrder->id;
        }

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
