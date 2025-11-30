<?php

namespace App\Http\Traits;

use App\Models\Driver;
use App\Models\DriverOrder;
use App\Services\DriverService;
use App\Services\GoogleService;
use App\Events\NewRideAvailable;
use App\Events\CancelledOrderEvent;

trait AssignDriverTrait
{
    /**
     * Assigns an order to a driver.
     *
     * @param \App\Models\Order $order
     * @param String $pickAddress
     * @return void
     */
    public function assignOrderToDriver($order, $pickAddress, $alreadyInPending = []): void
    {
        $drivers = $this->getDrivers($pickAddress);

        $alreadyRejectOrders = $order->assignedDrievrs->pluck('driver_id')->toArray();

        if(!empty($alreadyInPending)){
            $alreadyInPending = DriverOrder::where('status', 'pending')->pluck('driver_id')->toArray();
        }

        // Filter out drivers who have already rejected this order or are already in pending status
        $drivers = $drivers->whereNotIn('id', array_merge($alreadyInPending, $alreadyRejectOrders));

        $order->assignedDrievrs()->update(['status' => 'rejected']);
        // If drivers are available, assign the nearest one
        if (!$drivers->isEmpty()) {
            $order->update([
                'status' => 'pending',
                'updated_at' => now(),
            ]); // Update status to get last order activity

            $driver = $drivers->first();
            $order->assignedDrievrs()->create([
                'driver_id' => $driver->id,
                'status' => 'pending',
            ]);

            $user = Driver::find($driver->id)->user;
    
            event(new NewRideAvailable($order, $user->id));
        }else{
            // If no drivers are available, Order is automatically canceled
            $order->update(['status' => 'cancelled']);
            $order->rider->update(['on_trip' => false]);
            // Notify the user about the cancellation
            $order->assignedDrievrs()->delete();
            CancelledOrderEvent::dispatch($order->id, $order->rider->user_id);
        }
    }

    public function getDrivers($address)
    {
        $location = GoogleService::geocodeAddress($address);
        return DriverService::findNearbyDrivers($location['lat'], $location['lng']);
    }
}
