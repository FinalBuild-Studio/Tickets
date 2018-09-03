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

        if (!isset($_POST['ipn_mode'], $_POST['merchant'], $_POST['status'], $_POST['status_text'])) {
            throw new PaymentException(412, 'Insufficient POST data provided.');
        }

        if ($_POST['ipn_mode'] == 'httpauth') {
            if ($_SERVER['PHP_AUTH_USER'] !== $merchantId) {
                throw new PaymentException(412, 'Invalid merchant ID provided.');
            }

            if ($_SERVER['PHP_AUTH_PW'] !== $ipnSecret) {
                throw new PaymentException(412, 'Invalid IPN secret provided.');
            }
        } elseif ($_POST['ipn_mode'] == 'hmac') {
            $hmac = hash_hmac('sha512', file_get_contents('php://input'), $ipnSecret);

            if ($hmac !== $_SERVER['HTTP_HMAC']) {
                throw new PaymentException(412, 'Invalid HMAC provided.');
            }

            if ($_POST['merchant'] !== $merchantId) {
                throw new PaymentException(412, 'Invalid merchant ID provided.');
            }
        } else {
            throw new PaymentException(412, 'Invalid IPN mode provided.');
        }

        $orderStatus = $_POST['status'];

        // If $order_status is >100 or is 2, then it is complete
        $orderStatus = ($orderStatus >= 100 || $orderStatus == 2)

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

        if ($orderStatus) {
            // Send email to indicate you've paid the ticket
            Mail::to($order->email)->queue(new OrderConfirmed($order));

            $order->status = Order::PAID;
            $order->save();
        }

        return response('', 204);
    }
}
