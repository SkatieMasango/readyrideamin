<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Rider;


class DriverLocationUpdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $riderIds;


    public function __construct($order)
    {
        $this->order = $order;
        $rider = Rider::find($order->rider_id);
        $this->riderIds = $rider ? $rider->user_id : null;

    }

    public function broadcastOn()
    {
        return new Channel('driver-current-location.' . $this->riderIds);
    }

    public function broadcastAs()
    {
        return 'driver-current-location-notification';
    }

    public function broadcastWith()
    {
        $location = json_decode($this->order->driver?->current_location, true) ?? [];

        return [
            'message' => 'Your Driver Current location',
            'order_id' => $this->order->id,
            'data' => [
                'lat' => $location['lat'] ?? null,
                'lng' => $location['lng'] ?? null,
            ]
        ];
    }



}
