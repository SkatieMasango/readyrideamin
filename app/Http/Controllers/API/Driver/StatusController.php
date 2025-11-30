<?php

namespace App\Http\Controllers\API\Driver;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\JsonResponse;
use App\Repositories\DriverRepository;
use App\Http\Resources\Rider\OrderResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\AssignDriverTrait;
use App\Enums\OrderStatus;
use App\Enums\PaymentType;
use App\Events\OrderPayment;
use App\Events\StatusEvent;
use App\Models\Rider;
use Illuminate\Support\Carbon;

class StatusController extends Controller
{
    use AssignDriverTrait;
    /**
     * Get the current status of the driver.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus($orderId, $status)
    {
       $order = OrderRepository::findOrFail($orderId);

        if ($order->status === OrderStatus::CANCELLED) {
            return $this->json(message: 'Order has been cancelled');
        }

        return match ($status) {
            "accepted" => $this->acceptOrder($order),
            "rejected" => $this->declineOrder($order),
            "go_to_pickup" => $this->startOrder($order),
            "confirm_arrival" =>$this->confirmArrival($order),
            "picked_up" => $this->pickedOrder($order),
            "start_ride" => $this->startWithPassenger($order),
            "dropped_off" => $this->dropOrder($order),
            "completed" => $this->completeOrder($order),
        };
    }

    public function acceptOrder($order): JsonResponse
    {
        if ($order->status !== OrderStatus::PENDING) {
            return $this->json('Order is not available for acceptance',[],422);
        }

        $driver = DriverRepository::query()->where('user_id', Auth::id())->first();

        $cappableForAccept = $order->assignedDrievrs()->where('driver_id', $driver->id)->where('status', 'pending')->first();
        if(!$cappableForAccept){
            return $this->json('You can not accept this order',[],422);
        }

        $order->update([
            'status' => OrderStatus::ACCEPTED,
            'driver_id' => $driver->id,
        ]);

        $driver->update(['on_trip' => true]);

        StatusEvent::dispatch($order, 'Your ride has been accepted by the driver.');

        return $this->json(message: 'Thanks for accepting the ride', data:  OrderResource::make($order));
    }

    public function declineOrder($order)
    {
        $driverId = Auth::user()->driver->id;

        $cappableForReject = $order->assignedDrievrs()->where('driver_id', $driverId)->where('status', 'pending')->first();
        if($cappableForReject){
            $pickAddress = json_decode($order->addresses)->pickup_address;
            $this->assignOrderToDriver($order, $pickAddress);
            return $this->json(message: 'Ride is Declined successfully', data:  OrderResource::make($order));
        }
        return $this->json('You can not decline this order',[],422);
    }

    public function startOrder($order): JsonResponse
    {
        if ($order->status !== OrderStatus::ACCEPTED) {
            return $this->json('Order is not available for starting',[],422);
        }

        $order->update([
            'status' => OrderStatus::GO_TO_PICKUP,
        ]);

        StatusEvent::dispatch($order, 'Your driver has going to pick up. Have a safe trip!');
        return $this->json(message: 'Thanks for going to pick up the rider, Have a safe trip!', data:  OrderResource::make($order));

    }
    public function startWithPassenger($order): JsonResponse
    {
        if ($order->status !== OrderStatus::PICKED_UP) {
            return $this->json('Order is not available for starting',[],422);

        }

        $order->update([
            'status' => OrderStatus::START_RIDE,
        ]);

        StatusEvent::dispatch($order, 'Your ride has started. Have a safe trip!');
        return $this->json(message: 'Thanks for starting the ride, Have a safe trip!', data:  OrderResource::make($order));

    }
    public function confirmArrival($order): JsonResponse
    {
        if ($order->status !== OrderStatus::GO_TO_PICKUP) {
            return $this->json('Order is not available for confirming arrival',[],422);
        }

        $order->update([
            'status' => OrderStatus::CONFIRM_ARRIVAL,
        ]);

        StatusEvent::dispatch($order, 'Your driver has confirmed the arrival. Have a safe trip!');
        return $this->json(message: 'Thanks for confirming the arrival!', data:  OrderResource::make($order));

    }

    public function stopPoint($order): JsonResponse
    {
        if ($order->status !== OrderStatus::PICKED_UP) {
            return $this->json('Order is not available for stop point',[],422);
        }

        $order->update([
            'status' => OrderStatus::STOP_POINT,
            'start_timestamp' => Carbon::now(),
        ]);

        StatusEvent::dispatch($order, 'Your are on the stop point. Please wait for the next instructions.');
        return $this->json(message: 'Thanks for stopping at the stop point!', data:  OrderResource::make($order));

    }

    public function pickedOrder($order): JsonResponse
    {
        if ($order->status !== OrderStatus::CONFIRM_ARRIVAL) {
             return $this->json('order is not available for pickup',[],422);
        }
        $order->update([
            'status' => OrderStatus::PICKED_UP,
            'start_timestamp' => Carbon::now(),
        ]);

        StatusEvent::dispatch($order, 'Your driver has picked you. Have a safe trip!');
        return $this->json(message: 'Thanks for picked up!', data:  OrderResource::make($order));

    }

    public function progressOrder($order): JsonResponse
    {
        if ($order->status == OrderStatus::STOP_POINT || $order->status == OrderStatus::PICKED_UP) {
            $order->update([
                'status' => OrderStatus::IN_PROGRESS,
                'start_timestamp' => Carbon::now(),
            ]);

            StatusEvent::dispatch($order, 'Your ride has been in progress. Have a safe trip!');

            return successResponse(data: new OrderResource($order), message: 'Thanks for progressing the ride, Have a safe trip!');
        }
        return $this->json(message: 'order is not available for progress');
    }

    public function dropOrder($order): JsonResponse
    {
        if ($order->status == OrderStatus::START_RIDE || $order->status == OrderStatus::PICKED_UP) {
            $order->update([
            'status' => OrderStatus::DROPPED_OFF,
            'finish_timestamp' => Carbon::now(),
        ]);

         $duration = $order->start_timestamp->diffInMinutes($order->finish_timestamp);
            if($order->duration_best < $duration){
                $time = $duration - $order->duration_best;

            if ($order->service->over_minutes > 0) {
                $time = $time / $order->service->over_minutes;
                $amount = $order->service->per_minute_drive * $time;

                $order->update([
                    'cost_best' => $order->cost_best + $amount
                ]);
            }

            }

        $userID = Auth::id();
        $driver = DriverRepository::query()->where('user_id',  $userID)->first();
        $rider = Rider::query()->where('id', $order->rider_id)->first();
        $rider->update(['on_trip' => false]);
        $driver->update(['on_trip' => false]);

        $order->assignedDrievrs()->delete();

        StatusEvent::dispatch($order, 'Your driver has dropped you off. Thank you for riding with us!');
        return $this->json(message: 'Thanks for dropping off!', data:  OrderResource::make($order));

        }
        return $this->json('order is not available for drop off',[],422);
    }

    public function completeOrder($order)
    {

        if ( $order->status !== OrderStatus::DROPPED_OFF) {
                return $this->json('Order is not available for completion',[
                ],422);
            }

            $order->update([
                'status' => OrderStatus::COMPLETED,
                'payment_mode' => PaymentType::CASH
            ]);

            if($order->coupon_id){
                DB::table('coupon_rider')->insert([
                    'rider_id' => $order->rider_id,
                    'coupon_id' => $order->coupon_id,
                    'usage_count' => 1,
                    ]);
                }
            event(new OrderPayment($order, $order->driver_id));

            StatusEvent::dispatch($order, 'Your ride has completed. Thank you for riding with us!');

        return $this->json(message: 'Thanks for completing the ride!', data:  OrderResource::make($order));
    }
}
