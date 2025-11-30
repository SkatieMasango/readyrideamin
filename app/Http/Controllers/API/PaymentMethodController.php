<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;


class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentGateway::where('status', 'active')
            ->where('type', '!=', 'cash') 
            ->get()
            ->map(function ($method) {
                return [
                    'id' => $method->id,
                    'value' => $method->type,
                    'logo' => optional($method->gatewayPicture()->first())->url,
                ];
            });


        return $this->json('payment method', [
            'paymentMethods' => $paymentMethods,
        ], 200);
    }

}
