<?php

namespace App\Http\Controllers;

use Mail;
use App\Order;
use App\Mail\OrderConfirmed;
use App\Exceptions\PaymentException;
use Illuminate\Http\Request;

class IPNController extends Controller
{

    public function store(Request $request)
    {
        // Fill these in with the information from your CoinPayments.net account.
        $merchantId = env('PAYMENT_MERCHANT_ID');
        $ipnSecret  = env('PAYMENT_IPN_SECRET');

        $ipnMode  = $request->input('ipn_mode');
        $merchant = $request->input('merchant');
        $hmac     = $request->header('hmac');

        if ($ipnMode != 'hmac') {
            throw new PaymentException(412, 'IPN Mode is not HMAC');
        }

        if (!$hmac) {
            throw new PaymentException(412, 'No HMAC signature sent.');
        }

        if ($merchant != trim($merchantId)) {
            throw new PaymentException(412, 'No or incorrect Merchant ID passed');
        }

        $hmacHash = hash_hmac('sha512', $request->getContent(), trim($ipnSecret));
        if (!hash_equals($hmac, $hmacHash)) {
            throw new PaymentException(412, 'HMAC signature does not match');
        }

        //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field.
        $currency = env('PAYMENT_CURRENCY', 'TWD');

        $currency1  = $request->input('currency1');
        $amount1    = $request->input('amount1');
        $status     = $request->input('status');
        $statusText = $request->input('status_text');
        $itemNumber = $request->input('item_number');

        $order = Order::where('reference', $itemNumber)
            ->lockForUpdate()
            ->firstOrFail();

        // convert amount to integer
        $amount1 = (int) $amount1;

        if ($currency1 != $currency) {
            throw new PaymentException(412, 'Original currency mismatch!');
        }

        // Check amount against order total
        if ($amount1 < $order->amount) {
            throw new PaymentException(412, 'Amount is less than order total!');
        }

        if ($status >= 100 || $status == 2) {
            // Send email to indicate you've paid the ticket
            Mail::to($order->email)->queue(new OrderConfirmed($order));

            $order->status = Order::PAID;
            $order->save();
        }

        return response('', 204);
    }
}
