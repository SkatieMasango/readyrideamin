<?php

namespace App\Http\Controllers\API\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\DriverRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Repositories\WithdrawRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

       public function wallet()
    {
        $userId = Auth::id();
        $driver = DriverRepository::findDriver($userId);
        $wallet = WalletRepository::findDriverWallet($driver->user_id);

        $transactions = TransactionRepository::findDriverTransactions($driver->id)->get();
        $withdrawHistory = $transactions->where('payment_mode','withdraw')->sum('amount');
        $receiveHistory = $transactions->where('payment_mode','received')->sum('amount');

        return $this->json('Wallet fetched successfully.' ,[
            'wallet' => $wallet?->amount,
            'payment_withdraw' => $withdrawHistory,
            'payment_history' => $receiveHistory,
        ]);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string',
        ]);

        $userId = Auth::user()->id;
        $driver = DriverRepository::findDriver($userId);
        $wallet = WalletRepository::findDriverWallet($driver->user_id);

        if($wallet->amount < $request->amount){
            return $this->json(message: 'Insufficient balance', statusCode:422);
        }
        $transaction = TransactionRepository::createTransaction($request, $driver->id, 'withdraw', 'debit');
        $withdraw = WithdrawRepository::requestWithdrawByDriver($request, $driver->id, $transaction->id);

        return $this->json('Withdraw request sent successfully.' ,[
                    'withdraw amount' =>(float) $withdraw?->amount
                ], 201);

    }

    public function transactionDetails(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $driver = DriverRepository::findDriver($userId);

        $filter = $request->input('filter');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $specificDate = $request->input('date');
        $specificMonth = $request->input('month');
        $paymentMode = $request->input('payment_mode');

        $transactions = TransactionRepository::findDriverTransactions($driver->id);

        if ($specificDate) {
            $transactions->whereBetween('created_at', [
                Carbon::parse($specificDate)->startOfDay(),
                Carbon::parse($specificDate)->endOfDay(),
            ]);
        } elseif ($specificMonth) {
            $transactions->whereBetween('created_at', [
                Carbon::parse($specificMonth . '-01')->startOfMonth(),
                Carbon::parse($specificMonth . '-01')->endOfMonth(),
            ]);
        } elseif ($filter === 'custom' && $startDate && $endDate) {
            $transactions->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        if ($paymentMode) {
            $transactions = $transactions->where('payment_mode', $paymentMode)->where('transaction','debit');
        }
        $transactions = $transactions->orderBy('created_at', 'desc')->get();

        return $this->json('Transaction history fetched successfully.', [
            'Transaction' => TransactionResource::collection($transactions),
        ]);
    }

}
