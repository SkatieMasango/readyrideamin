<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enums\OrderStatus;
use App\Models\Driver;
use App\Models\Rider;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

class TransactionRepository extends Repository
{
    public static function model()
    {
        return Transaction::class;
    }

    public static function findDriverTransactions($id){
        return self::query()->where('driver_id', $id);
    }

    public static function createTransaction($request, $driverId, $mode, $type,$amount=null ,$paymentMethod = null){

         return self::create([
            'driver_id' => $driverId,
            'rider_id' =>$request->rider_id ?? null ,
            'amount' => $amount ?? $request->amount ,
            'order_id' => $request->id ?? null,
            'method' =>  $paymentMethod ?? $request->method,
            'transaction' => $type,
            'payment_mode' =>  $mode,
        ]);
    }

    public static function makePayment($order, $paymentMethod){
        $order->update([
            'payment_status' => 1,
            'status' => OrderStatus::COMPLETED
        ]);
        // $rider = Rider::find($order->rider_id);
        // $rider->update([
        //     'on_trip' => false
        // ]);

        $driver =Driver::find($order->driver_id);
        // $driver->update([
        //     'on_trip' => false
        // ]);

        $setting = Settings::query()->where('key', 'site_config')->value('value');

        $generalSettings = $setting ? json_decode($setting) : [];

        $creditAmount = $order->cost_best * $generalSettings->commision / 100 ;
        $debitAmount = $order->cost_best - $creditAmount;

        $transaction = TransactionRepository::createTransaction($order, $driver->id, 'received', 'credit',$creditAmount , $paymentMethod->type);

        if($transaction->transaction === 'credit'){
            $root = User::role('root')->first();
            $wallet = Wallet::where('user_id', $root->id)->first();
            $amount = $wallet->amount + $transaction->amount;
            $wallet->update([
                'amount' => $amount ,
            ]);
        }

        $transaction = TransactionRepository::createTransaction($order, $driver->id, 'received', 'debit',$debitAmount , $paymentMethod->type);

        if($transaction->transaction === 'debit'){
            $wallet = Wallet::where('user_id', $driver->user_id)->first();
            $amount = $wallet->amount + $transaction->amount;
            $wallet->update([
                'amount' => $amount ,
            ]);
        }
        return $transaction;

    }
}
