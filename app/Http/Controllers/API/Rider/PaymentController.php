<?php

namespace App\Http\Controllers\API\Rider;

use App\Events\OrderOnlinePayment;
use App\Events\OrderPayment;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\PaymentGateway;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function index()
    {
        $userEmail = Auth::user()->email;

        $paymentMethods = PaymentGateway::where('status', 'active')->get()->map(function ($method) {
            return [
                'id' => $method->id,
                'value' => $method->type,
                'logo' => $method->gatewayPicture()->first()->url,
                'secret_key' => json_decode($method->config)->secret_key,
                'public_key' => json_decode($method->config)->public_key,
            ];
        });

        if (is_null($userEmail)) {
            $paymentMethods = $paymentMethods->filter(function ($gateway) {
                return $gateway['value']->value !== 'paystack';
            })->values();
        }

        return $this->json('Payment Information.' ,[
            'paymentMethods' => $paymentMethods->toArray()
        ], 201);
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string'
        ]);

        $order = Order::find($request->order_id);
        $order->update([
            'payment_mode' => $request->payment_method
        ]);
        $user = Auth::user();

        if (!$order) {
            return $this->json('Order not found.' ,[], 404);
        }

        $amount = $order->cost_after_coupon > 0 ? $order->cost_after_coupon : $order->cost_best;

        if($request->payment_method == 'stripe'){
            $payment = (new StripeService())->paymentSuccess($order,$user,$amount);
        }else{
            $order->update([
            'payment_status' => true
        ]);
        }
        


        return $this->json('Payment Information.', [
            'redirectUrl' => $payment ?? null,
        ]);
    }


    public function invoice()
    {
        return $this->json('Successfully Payment Complete');
    }


    public function cancelPayment()
    {
        return $this->json('Payment Cancelled.', statusCode: 400);
    }
}
