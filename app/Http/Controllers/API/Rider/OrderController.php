<?php

namespace App\Http\Controllers\API\Rider;

use App\Models\Order;
use App\Models\Rider;
use App\Enums\OrderStatus;
use App\Events\StatusEvent;
use App\Models\DriverOrder;
use App\Services\GoogleService;
use Illuminate\Http\JsonResponse;
use App\Events\CancelledOrderEvent;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Repositories\RiderRepository;
use App\Http\Traits\AssignDriverTrait;
use App\Repositories\CouponRepository;
use App\Repositories\ServiceRepository;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\Rider\OrderResource;
use App\Http\Resources\Rider\ServiceResource;
use App\Repositories\DriverRepository;
use App\Repositories\ServiceOptionRepository;
use App\Services\DriverService;

class OrderController extends Controller
{
    use AssignDriverTrait;
    public function index(): JsonResponse
    {
        $request = request();
        $request->validate([
            'status' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        $status = $request->status;
        $date = $request->date;

        $rider = Rider::where('user_id', Auth::id())->first();
        $orders = $rider->orders()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('created_at', "LIKE", '%' . $date . '%');
            })
            ->latest('id')
            ->get();

        if ($orders->isEmpty()) {
            return $this->json(message: 'No Order Available');
        }

        return $this->json('The ride history retrieved successfully', data:[
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function show(int $orderId): JsonResponse
    {
        $order = Order::findOrFail($orderId);
        return $this->json(data: new OrderResource($order), message: 'Order Found');
    }

    public function createOrder(CreateOrderRequest $request)
    {

        $rider = RiderRepository::query()->where('user_id', Auth::id())->first();

        $drivers = $this->getDrivers($request->pickup_address);
        $alreadyInPending = DriverOrder::where('status', 'pending')->pluck('driver_id')->toArray();

        $drivers = $drivers->whereNotIn('id', $alreadyInPending);

        if($rider->on_trip) {
            return $this->json('You are already on a trip.', statusCode:422);
        } elseif ($drivers->isEmpty()) {
            return $this->json('We are sorry, no drivers available at the moment.', statusCode: 422);
        }

        $pickupLocation = $request->get('pickup_location');
        $dropLocation = $request->get('drop_location');
        $waitLocation = $request->get('wait_location');

        if(!$waitLocation){
            if ($pickupLocation === $dropLocation) {
                return $this->json('Pickup and drop locations must be different.', statusCode:422);
            }
        }
        // get distance and duration
        $matrix = GoogleService::getDistanceAndDuration($pickupLocation[0], $pickupLocation[1], $dropLocation[0], $dropLocation[1]);

        if (! $matrix) {
            return $this->json(message: 'No route found', statusCode: 204);
        }

        $service = ServiceRepository::find($request->service_id);

        if (! $service) {
            return $this->json('Selected invalid service.', statusCode: 422);
        }

        $order = OrderRepository::storeByRequest($request, $service, $matrix, $rider);

        $this->assignOrderToDriver($order, $request->pickup_address, $alreadyInPending);

        return $this->json('Order is created successfully.' ,[
            'order' => OrderResource::make($order)
        ], 201);
    }

    public function couponApply(Request $request){
        $coupon = $request->get('coupon_code');
        $applyCouponed = CouponRepository::applyCoupon($coupon);
        if($applyCouponed){
            return $this->json('Coupon applied successfully.',statusCode:200);
        }else{
            return $this->json('Invalid coupon code.',statusCode:422);
        }
    }

    public function getFares(OrderRequest $request): JsonResponse
    {
        $pickupLocation = $request->get('pickup_location');
        $dropLocation = $request->get('drop_location');
        $waitLocation = $request->get('wait_location');

        if(!$waitLocation){
            if ($pickupLocation === $dropLocation) {
                return $this->json('Pickup and drop locations must be different.', statusCode:422);
            }
        }

        $services = ServiceRepository::getAll();

        if (!$services) {
            return $this->json(message: 'No services available for your location', statusCode: 200);
        }
        // get distance and duration
        $matrix = GoogleService::getDistanceAndDuration($pickupLocation[0], $pickupLocation[1], $dropLocation[0], $dropLocation[1]);
        if (! $matrix) {
            return $this->json(message: 'No route found');
        }

        // Service options fees
        $serviceOptionsFee = 0;
        if ($request->service_option_ids) {
            $serviceOptionsFee = ServiceOptionRepository::query()->whereIn('id', $request->service_option_ids)->sum('additional_fee');
        }

        $fares = [];
            $invalidCoupon = true;
            foreach ($services as $service) {
                $distance = $matrix['distance'];

                $serviceFare = $service->minimum_fee;

                if($service->fare < $distance ){
                    $distance = $distance - $service->fare;
                    $serviceFare = ServiceRepository::calculateFare(serviceId: $service->id, distance: $distance, duration: $matrix['duration']);
                    $serviceFare = $serviceFare + $service->minimum_fee;
                }

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

                $fares[] = [
                    'id' => $service->id,
                    'name' => $service->name,
                    'logo' => $service->servicePicture,
                    'duration' => $matrix['durationText'],
                    'person_capacity' => $service->person_capacity,
                    'minimum_fee' => (float) $service->minimum_fee,
                    'fare' => $service->fare,
                    'service_fare' => round($serviceFare , 2),
                    'cost_after_coupon' => $costAfterCoupon,
                    'is_coupon_applicable' => (bool) $couponValue,
                    'additional_fee' => (float) $serviceOptionsFee,
                    'total_fare'   => round(($fare == 0 ? $serviceFare : $fare) , 2),
                ];
            }

            if ($request->coupon_code && $invalidCoupon) {
                return successResponse([
                    'services' => $fares,
                    'distance_base' => $matrix['distance'],
                    'duration_base' => $matrix['duration'],
                    'distance' => $matrix['distanceText'],
                    'duration' => $matrix['durationText'],
                    'coupon_applied' => false,
                ], 'Invalid Coupon');
            }
            elseif($invalidCoupon = false){
                 return $this->json('Coupon applied successfully', [
                    'services' => $fares,
                    'distance_base' => $matrix['distance'],
                    'duration_base' => $matrix['duration'],
                    'distance' => $matrix['distanceText'],
                    'duration' => $matrix['durationText'],
                ], 200);

                }

        usort($fares, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });
        return $this->json('Successfully retrieve services for your location', [
            'services' => $fares,
            'distance_base' => $matrix['distance'],
            'duration_base' => $matrix['duration'],
            'distance' => $matrix['distanceText'],
            'duration' => $matrix['durationText'],
        ], 200);
    }

    public function onTrip(): JsonResponse
    {
        $rider = Rider::where('user_id', Auth::id())->first();

        $order = $rider->orders()->whereNotIn('status', [OrderStatus::CANCELLED, OrderStatus::COMPLETED])->latest()->first();

        if (!$order) {
            return $this->json('No active trip found',[
                'order' => null
            ], statusCode: 200);
        }

        return $this->json('Successfully retrieve active trip',[
            'order' => OrderResource::make($order)
        ]);
    }

    public function cancelOrder($orderId): JsonResponse
    {
        $order  = Order::findOrFail($orderId);
        if ($order->status === OrderStatus::CANCELLED) {
            return $this->json(message: 'Order cannot be cancelled', statusCode:200);
        }
        $user = Auth::user();
        $driver = $user->driver;
        $rider = $user->rider;

        if($rider){
            $order->update(['status' => OrderStatus::CANCELLED]);
            $rider->update(['on_trip' => false]);

            if($order->driver_id){
                $driver = DriverRepository::find($order->driver_id);
                if ($driver) {
                    $driver->update(['on_trip' => false]);
                    CancelledOrderEvent::dispatch($order->id, $driver->user_id);
                }

            }else{
                $assignedDriverIds = DriverOrder::where('order_id', $order->id)->pluck('driver_id')->toArray();
                    if (!empty($assignedDriverIds)) {
                        foreach ($assignedDriverIds as $driverId) {
                            $driver = DriverRepository::find($driverId);

                            if ($driver) {
                                $driver->update(['on_trip' => false]);
                                CancelledOrderEvent::dispatch($order->id, $driver->user_id);

                            }
                        }
                    }
            }
             StatusEvent::dispatch($order, 'Order has been cancelled by rider', true);
        }
        elseif($driver){
            $driver->update(['on_trip' => false]);
            $order->update(['status' => OrderStatus::PENDING]);
            $pickAddress = json_decode($order->addresses)->pickup_address;
            $this->assignOrderToDriver($order, $pickAddress);
            StatusEvent::dispatch($order, 'Order has been cancelled by driver', true);

         }

        DriverOrder::where('order_id', $order->id)->delete();
        return $this->json(message: 'Order has been cancelled by rider', statusCode:200);
    }

    public function getServices(): JsonResponse
    {
        $services = ServiceRepository::getAll();

        if ($services->isEmpty()) {
            return $this->json(message: 'No services available', statusCode: 200);
        }
        return $this->json('Successfully retrieve services', [
            'services' => ServiceResource::collection($services)
        ]);
    }

    public function getDriversLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        $locations = DriverService::getNearbyDrivers($request->latitude, $request->longitude);

        return $this->json('Nearby drivers locations', [
            'locations' => $locations
        ]);
    }

    public function generateInvoiceDownload($id){

        return $this->json('certificate url', [
             'url' => route('generate-invoice', ['id' => $id]),
        ]);
    }
}
