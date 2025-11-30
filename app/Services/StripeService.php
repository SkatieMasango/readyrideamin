<?php

namespace App\Services;

use App\Models\PaymentGateway;
use Stripe\Stripe;


class StripeService
{
    protected $publishedKey;
    protected $secretKey;

    public function __construct()
    {
        $paymentMethod = PaymentGateway::where('type', 'stripe')->first();

        if ($paymentMethod) {
            $config = json_decode($paymentMethod->config);
            $this->publishedKey = $config->public_key ?? null;
            $this->secretKey = $config->secret_key ?? null;

            if ($this->secretKey) {
                Stripe::setApiKey($this->secretKey);
            }
        }
    }

    public function paymentSuccess($order, $user, $amount)
    {
        $successUrl = route('payment.success');
        $cancelUrl  = route('payment.cancel');

        if (!$this->publishedKey || !$this->secretKey) {

            return $this->json('Stripe credentials are not configured.',[
                'message' => 'Stripe credentials are not configured.'
            ], 400);
        }

        try {
            $callbackUrl = $successUrl . '?' . http_build_query([
                'payment' => 'stripe',
                'order_id' => $order->id,
            ]);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'Order #' . $order->id],
                        'unit_amount' => (int)($amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $callbackUrl . '&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $cancelUrl . '?payment=stripe',
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                ],
            ]);
            return $session->url;

        } catch (\Exception $e) {
             return $e->getMessage();
        }
    }

}
