<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturnController extends Controller
{

    public function index(Request $request, $reference)
    {
        $key   = $request->query('key');
        $order = Order::join('events', 'events.id', 'orders.event_id')
            ->whereDate('start_at', '>', new Carbon('+1 days'))
            ->where('reference', $reference)
            ->where('status', Order::PAID)
            ->where('amount', 0)
            ->firstOrFail();

        if (!$key || $order->key !== $key) {
            throw new GeneralException(400, '驗證不正確');
        }

        // delete your order
        Order::where('reference', $reference)->first()->delete();

        return redirect()
            ->action('IndexController@index')
            ->with('message', '您已經成功退訂票券');
    }
}
