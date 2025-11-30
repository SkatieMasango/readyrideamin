<?php

namespace App\Services;

use App\Models\PayoutGateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PayoutService
{
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

}
