<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Rider;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RiderRepository extends Repository
{
    public static function model()
    {
        return Rider::class;
    }

    public static function getTotalRiders(){
        return self::query()->with('user')->orderBy('created_at', 'desc')->get();
    }
    public static function getRealTimeRider(){
        $today = Carbon::today();
          return self::query()
        ->join('orders', 'orders.rider_id', '=', 'riders.id') // reverse the join
        ->whereDate('orders.created_at', $today)
        ->where('riders.on_trip', 1)
        ->select('riders.*')
        ->distinct()
        ->get();

        return self::query()->with('user')->where('on_trip', true)
        ->orderBy('created_at', 'desc')->get();
    }
}
