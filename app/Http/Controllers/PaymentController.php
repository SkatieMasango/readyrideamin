<?php

namespace App\Http\Controllers;

use App\Events\OrderOnlinePayment;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Repositories\TransactionRepository;

class PaymentController extends Controller
{

    public function showCheckout(Request $request)
    {
        return view('checkout', [
            'razorpay_order_id' => $request->query('razorpay_order_id'),
            'order_id' => $request->query('order_id'),
            'key' => $request->query('key'),
            'amount' => $request->query('amount'),
            'currency' => $request->query('currency'),
            'email' => $request->query('email'),
            'name' => $request->query('name'),
        ]);
    }

    public function successPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $paymentMethod = $request->input('payment');
        $order = Order::find($request->order_id);

        if($paymentMethod == 'stripe'){
            $paymentMethod = PaymentGateway::where('type','stripe')->first();
            $secret_key = json_decode($paymentMethod->config)->secret_key;
            \Stripe\Stripe::setApiKey($secret_key);
            $sessionId = $request->input('session_id');
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if ($session->payment_status === 'paid') {
                (new TransactionRepository())->makePayment($order, $paymentMethod);
                event(new OrderOnlinePayment($order, $order->driver->user_id));
                // $order->assignedDrievrs()->delete();
            }
            return to_route('payment.success.response');
        }

        return $this->json('Payment was completed successfully');
    }

    public function success()
    {
        return $this->json('Payment done successfully.');
    }

    public function cancelPayment()
    {
        return $this->json('Payment not completed.');
    }
}
