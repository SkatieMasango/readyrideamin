<?php

namespace App\Http\Controllers\API\Driver;

use App\Http\Controllers\Controller;
use App\Enums\OrderStatus;
use App\Events\CurrentRidePosition;
use App\Models\Driver;
use App\Models\Order;
use App\Events\DriverLocationUpdate;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function updateCurrentLocation(Request $request)
    {
        $request->validate([
            'location' => 'required',
        ]);

        $coordinates = $request->location;
        $location = [
            'lat' => $coordinates[0],
            'lng' => $coordinates[1],
        ];

        $user = Auth::user();
        $driver = $user->driver;

        $driver->update([
            'current_location' => $location,
        ]);

        $order = Order::where('driver_id', $driver->id)->with('driver')->first();

        // Update the driver's current location in the location storage service
        // This will also trigger the DriverLocationUpdate event
        if($order && in_array($order->status, ['pending','accepted','rejected','go_to_pickup','confirm_arrival'])){
            DriverLocationUpdate::dispatch($order);
        }

        return $this->json('Current location updated successfully', statusCode:200);
    }
    public function currentRidePosition(Request $request){
        $data = $request->all();

        $driver = Driver::where('user_id', Auth::id())->first();
        $order = $driver->orders()->whereNotIn('status', [OrderStatus::CANCELLED, OrderStatus::COMPLETED])->latest()->first();

        $rider = Rider::find($order->rider_id);

        // Dispatch the event to update the rider's current ride position
        // This will trigger the CurrentRidePosition event to notify the rider
        CurrentRidePosition::dispatch($data, $rider->user_id);

        return $this->json('Current ride position sent successfully', statusCode:200);
    }

}





