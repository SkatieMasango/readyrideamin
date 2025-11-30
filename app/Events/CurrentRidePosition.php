<?php

namespace App\Events;

use App\Models\Rider;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrentRidePosition implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $riderUserId;
    public $data;

    public function __construct($data, $rider)
    {
        $this->data = $data;

        $this->riderUserId =  $rider;

    }

    public function broadcastOn()
    {
        return new Channel('driver-current-location.' . $this->riderUserId);
    }

    public function broadcastAs()
    {
        return 'send-travel-info-notification';
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Your Driver Current location',

            'data' => [
                'minute'          => $this->data['minute'] ?? null,
                'distance'        => $this->data['distance'] ?? null,
                'progress'        => $this->data['progress'] ?? 0,
                'destination'     => $this->data['destination'] ?? null,
                'driver_location' => $this->data['driver_location'] ?? null,
                'polyline'        => $this->data['polyline'] ?? [],
            ],
        ];
    }
}
