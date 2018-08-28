<?php

namespace App\Http\Controllers;

use App\{Order, Event};
use Carbon\Carbon;
use App\Exceptions\GeneralException;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function store(Request $request, $eventId)
    {
        $crypto  = $request->input('crypto', 0);
        $free    = $request->input('free', 0);
        $sponsor = $request->input('sponsor', 0);

        $event = Event::where('id', $eventId)
            ->whereDate('start_at', '>', new Carbon('+1 days'))
            ->firstOrFail();
        $total = ($crypto + $free);

        if ($sponsor && $total) {
            throw new GeneralException(400, '贊助票不得與付費票一起結帳');
        }

        if ($total > 3) {
            throw new GeneralException(400, '一般票券限購三張');
        }

        if ($sponsor > 1) {
            throw new GeneralException(400, '贊助票券限購一張');
        }

        if ($total > $event->left) {
            throw new GeneralException(400, '活動剩餘人數不足');
        }

        if (!$sponsor && !$total) {
            throw new GeneralException(400, '請輸入大於0的票數');
        }

        if ($sponsor > $event->left_sponsor_tickets) {
            throw new GeneralException(400, '贊助票已售完');
        }

        $amount    = $event->price * $crypto;
        $reference = substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);

        // Create new order
        $order             = new Order();
        $order->reference  = $reference;
        $order->amount     = $amount;
        $order->total      = $total + $sponsor;
        $order->event_id   = $eventId;
        $order->is_sponsor = $sponsor ? true : false;
        $order->save();

        return view('checkout.store', compact('event', 'order'));
    }
}
