<?php

namespace App\Http\Controllers;

use App\Order;

class ConfirmController extends Controller
{

    public function index($reference)
    {
        $order = Order::where('reference', $reference)
            ->whereIn('status', [Order::PAID, Order::CONFIRM])
            ->firstOrFail();

        return view('confirm.index', compact('order'));
    }
}
