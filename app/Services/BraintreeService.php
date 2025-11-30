<?php

namespace App\Services;

use Braintree\Gateway;

class BraintreeService
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('services.braintree.env'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key'),
        ]);
    }

    public function createCustomer($user)
    {
        return $this->gateway->customer()->create([
            'firstName' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function addCard($customerId, $cardData)
    {
        return $this->gateway->paymentMethod()->create([
            'customerId' => $customerId,
            'paymentMethodNonce' => $cardData['nonce'], // Get this from client
            'options' => [
                'makeDefault' => true,
                'verifyCard' => true,
            ],
        ]);
    }

    public function listCards($customerId)
    {
        return $this->gateway->customer()->find($customerId)->paymentMethods;
    }
}
