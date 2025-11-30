<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enums\WithdrawStatus;
use App\Models\Wallet;
use App\Models\Withdraw;

class WithdrawRepository extends Repository
{
    public static function model()
    {
        return Withdraw::class;
    }
    public static function requestWithdrawByDriver($request, $driverId, $transactionId){
        return self::create([
            'driver_id' => $driverId,
            'amount' => $request->amount,
            'method' => $request->method ?? 'cash',
            'status' => WithdrawStatus::PENDING,
            'transaction_id' => $transactionId,
        ]);
    }

}
