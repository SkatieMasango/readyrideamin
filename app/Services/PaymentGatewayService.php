<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\PayoutGateway;
use App\Models\Rider;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Token;

class PaymentGatewayService
{
     public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.key'));
    }
    public static function StorePayout($request){
        $config = json_encode([
            'api_key' => $request->api_key,
            'secret_key' => $request->secret_key ?? null,
        ]);


        $paymentGateway = PayoutGateway::create([
            'mode' => $request->mode ?? '',
            'config' => $config,
        ]);

       return $paymentGateway;
    }
    public static function UpdatePayout($request, $payoutGateway){

        $payoutGateway = PayoutGateway::findOrFail($payoutGateway);

        $config = json_encode([
            'api_key' => $request->api_key,
            'secret_key' => $request->secret_key ?? null,
        ]);

        $payoutGateway->update([
            'mode' => $request->mode ?? '',
            'config' => $config,
        ]);

        return $payoutGateway;
    }

     public static function makeCustomer(int $id ,string $name, string $email = null, string $role)
    {

        $info = ['name' => $name];
        if($email)
            $info['email'] = $email;

         $stripeCustomer = \Stripe\Customer::create($info);

       if ($role === 'driver') {
            $user = Driver::where('user_id', $id)->first();
            if ($user) {
                $user->update([
                    'stripe_customer' => $stripeCustomer->id,
                ]);
            }
        } else {
            $user = Rider::where('user_id', $id)->first();
            if ($user) {
                $user->update([
                    'stripe_customer' => $stripeCustomer->id,
                ]);
            }
        }

        return $user;
    }

    public function getCardCustomerWise(string $stripeCustomer)
    {

        $cards = Customer::allPaymentMethods($stripeCustomer, ['type' => 'card']);

        $cardInfo = collect([]);
        foreach($cards->data as $data){
            $cardInfo[] = [
                'id' => $data->id,
                'brand' => $data->card->brand,
                'last4' => $data->card->last4,
                'exp_month' => $data->card->exp_month,
                'exp_year' => $data->card->exp_year,
                'country' => $data->billing_details->address->country,
                'card_holder_name' => $data->billing_details->name,
                'name' => "Stripe",
            ];
        }

         return $cardInfo;


    }

    public function deleteSource($stripeCustomer, $cardId)
    {

       $card = Customer::deleteSource(
            $stripeCustomer,
            $cardId
        );
        return $card;
    }


    public function cardSave($request, string $stripeCustomer)
    {

        $secretKey = config('services.stripe.key');

        Stripe::setApiKey($secretKey);
        $token = Token::create([
            'card' => [
                'number' => $request->number,
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
                'cvc' => $request->cvc,
                // 'address_zip' => $request->zip,
                'name' => $request->name,
                'address_country' => $request->address_country
            ],
        ]);
        $card = Customer::createSource(
            $stripeCustomer,
            ['source' => $token->id]
        );

        $card = collect([
            'id' => $card->id,
            'last4' => $card->last4,
            'brand' => $card->brand,
            'exp_month' => $card->exp_month,
            'exp_year' => $card->exp_year,
            'country' => $card->address_country,
            'card_holder_name' => $card->name,
            'name' => 'Stripe'
        ]);

        return $card;



    }

}
