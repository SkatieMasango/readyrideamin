<?php
namespace App\Repositories;

use App\Models\Order;
use App\Enums\OrderStatus;
use Abedin\Maker\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderRepository extends Repository
{
    public static function model()
    {
        return Order::class;
    }

    public static function storeByRequest($request, $service, $matrix, $rider)
    {
        $pickupLocation = $request->get('pickup_location');
        $dropLocation = $request->get('drop_location');
        $waitLocation = $request->get('wait_location');

        $serviceOptionsFee = 0;
        if ($request->service_option_ids) {
            $serviceOptionsFee = ServiceOptionRepository::query()->whereIn('id', $request->service_option_ids)->sum('additional_fee');
        }

        $distance = $matrix['distance'];
        $serviceFare = $service->minimum_fee;

        if($service->fare < $distance ){
            $distance = $distance - $service->fare;
            $serviceFare = ServiceRepository::calculateFare(serviceId: $service->id, distance: $distance, duration: $matrix['duration']);
            $serviceFare = $serviceFare + $service->minimum_fee;
        }
        // $fare = ($distance / $service->per_hundred_meters) ;

        // $couponValue = 0;
        // $coupon = null;
        // if ($request->coupon_code) {
        //     $coupon = CouponRepository::query()->where('code', $request->coupon_code)->first();
        //     $couponValue = CouponRepository::getDiscountAmount($request->coupon_code, $service->id, $serviceFare);
        // }
        // $costAfterCoupon = 0;
        // if($couponValue){
        //     $costAfterCoupon = $serviceFare - $couponValue;
        // }

        // $fare = $serviceFare + (float) $serviceOptionsFee;
        // if ($fare < (float) $service->minimum_fee) {
        //     $fare = (float) $service->minimum_fee;
        // }
            $coupon = null;
           $couponValue = 0;
                if ($request->coupon_code) {
                    $couponValue = CouponRepository::getDiscountAmount($request->coupon_code, $service->id, $serviceFare);
                    if ($couponValue > 0) {
                        $invalidCoupon = false;
                    }
                }
                $costAfterCoupon = 0;
                $fare = 0;
                if($couponValue){
                    $costAfterCoupon = $serviceFare - $couponValue;
                    $fare = $costAfterCoupon;
                }

                if($serviceOptionsFee){
                    $fare = ($fare == 0 ? $serviceFare : $fare) + (float) $serviceOptionsFee;
                }



        $distance = str_replace(['km', ' '], '', $matrix['distanceText']);
        $duration = str_replace(['mins', 'min', ' '], '', $matrix['durationText']);

        $order = self::create([
            'rider_id' => $rider->id,
            'service_id' => $service->id,
            'coupon_id' => $coupon?->id,
            'status' => OrderStatus::PENDING,
            'distance_best' => $distance,
            'duration_best' => $duration,
            'service_options_cost' => $serviceOptionsFee,
            'points' => json_encode(['pickup_location' => $pickupLocation, 'drop_location' => $dropLocation, 'wait_location' => $waitLocation]),
            'addresses' => json_encode(['pickup_address' => $request->pickup_address, 'drop_address' => $request->drop_address, 'wait_address' => $request->wait_address]),
            'cost_after_coupon' => $costAfterCoupon,
            'cost_best' => round(($fare == 0 ? $serviceFare : $fare) , 2),
        ]);


        //    'fare' => $service->fare,
        //             'service_fare' => round($serviceFare * 2, 2),
        //             'cost_after_coupon' => $costAfterCoupon,
        //             'is_coupon_applicable' => (bool) $couponValue,
        //             'additional_fee' => (float) $serviceOptionsFee,
        //             'total_fare'   => round(($fare == 0 ? $serviceFare : $fare) * 2, 2),




        $rider->update(['on_trip' =>  true]);

        if ($request->service_option_ids) {
            $order->serviceOptions()->sync($request->service_option_ids);
        }

        return $order;
    }

    public static function searchOrders()
    {
        $driver = DriverRepository::query()->where('user_id', Auth::id())->first();
        $validated = request()->validate([
            'search' => 'nullable|string|max:255',
            'date' => 'nullable|string',
        ]);

        $search = $validated['search'] ?? null;
        $date = $validated['date'] ?? null;

        return self::query()
            ->where('driver_id', $driver->id)
            ->when($search, function ($query) use ($search) {
                // Use parameter binding for LIKE query
                $query->where('status', 'LIKE', '%' . $search . '%');
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('created_at', $date === 'today' ? now()->toDateString() : $date);
            })->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getTopDrivers(){
             return self::query()->select('driver_id', DB::raw('count(*) as total'))
            ->whereNotNull('driver_id')
            ->where('status', OrderStatus::COMPLETED)
            ->with('driver')
            ->groupBy('driver_id')
            ->orderByDesc('total')
            ->take(6)
            ->get();
    }
    public static function getRealTimeRiders(){
        $today = Carbon::today();
        return self::query()->join('riders', 'orders.rider_id', '=', 'riders.id')
                    ->whereDate('orders.created_at', $today)
                    ->where('riders.on_trip', 1)
                    ->select(
                        DB::raw('HOUR(orders.created_at) as h'),
                        DB::raw('COUNT(DISTINCT orders.rider_id) as c')
                    )
                    ->groupBy('h')
                    ->get();
    }

     public static function getFilterReport(){
        $year = now()->format('Y');
        $month = now()->format('m');

        $orders = self::query()->where('status', OrderStatus::COMPLETED);

        if (request()->type == 'monthly') {
            $orders = $orders->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->get();
             $daysInMonth = Carbon::create($year, $month)->daysInMonth;
              $dailyCounts = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $dailyCounts[$i] = 0; // day number as key
            }
            foreach ($orders as $order) {
                $day = Carbon::parse($order->created_at)->day;
                $dailyCounts[$day]++;
            }

            $filterOrders = [
                'labels' => array_map(fn($d) => str_pad($d, 2, '0', STR_PAD_LEFT), array_keys($dailyCounts)), // ['01', '02', ..., '31']
                'values' => array_values($dailyCounts),
            ];


        } elseif (request()->type  ==  'yearly') {

            $orders = $orders->whereYear('created_at', $year)->get();

            $daysOfMonths = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec',];
            $monthlyCounts = array_fill_keys(array_values($daysOfMonths), 0);
            foreach ($orders as $order) {
                $monthNumber = Carbon::parse($order->created_at)->month;
                $monthName = $daysOfMonths[$monthNumber];
                $monthlyCounts[$monthName]++;
            }

            $filterOrders = [
                'labels' => array_keys($monthlyCounts),
                'values' => array_values($monthlyCounts),
            ];

        } else  {

            if(request()->type == 'daily' || request()->type == '' ){
                 $orders = $orders->whereDate('created_at', now())->get();
            }else{
                $orders = $orders->whereDate('created_at', request()->type)->get();
            }


            $timeSegments = [
                'Morning'   => 0,
                'Afternoon' => 0,
                'Evening'   => 0,
                'Night'     => 0,
            ];

            foreach ($orders as $order) {
                $hour = Carbon::parse($order->created_at)->hour;

                if ($hour < 6) {
                    $timeSegments['Morning']++;
                } elseif ($hour < 12) {
                    $timeSegments['Afternoon']++;
                } elseif ($hour < 18) {
                    $timeSegments['Evening']++;
                } else {
                    $timeSegments['Night']++;
                }
            }

            $filterOrders = [
                'labels' => array_keys($timeSegments),
                'values' => array_values($timeSegments),
            ];
        }

        return  $filterOrders;
    }

    public static function getLatest()
{
    return self::query()->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
}



}
