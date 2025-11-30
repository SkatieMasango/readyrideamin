<?php

namespace App\Http\Controllers\API\Driver;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $driver = Driver::where('user_id', $userId)->first();
        $wallet = Wallet::where('user_id', $driver->user_id)->first();

        $earning = Transaction::where('driver_id', $driver->id)
            ->where('payment_mode', 'received')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $cancelRide = Order::where('driver_id', $driver->id)->where('status', OrderStatus::CANCELLED)->count();
        $completedRide = Order::where('driver_id', $driver->id)->where('status', OrderStatus::COMPLETED)->count();

        return $this->json('Wallet successfully.' ,[
            'wallet' => $wallet?->amount,
            'today_earning' => $earning,
            'cancel_ride' => $cancelRide,
            'complete_ride' => $completedRide,
        ], 201);
    }
}
