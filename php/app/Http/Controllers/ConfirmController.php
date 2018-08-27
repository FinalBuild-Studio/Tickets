<?php

namespace App\Http\Controllers;

use App\Order;

class ConfirmController extends Controller
{

    public function index($reference)
    {
        $order = Order::where('reference', $reference)
            ->where('status', Order::PAID)
            ->firstOrFail();

        return view('confirm.index', compact('order'));
    }
}
