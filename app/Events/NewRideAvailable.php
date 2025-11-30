<?php

namespace App\Events;

use App\Repositories\UserRepository;
use App\Services\NotificationServices;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class NewRideAvailable implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data, $driverId;

    public function __construct($order, $driverId)
    {
        $address  = json_decode($order->addresses, true)  ?? [];
        $location = json_decode($order->points, true)  ?? [];

        $this->driverId = $driverId;
        $this->data =  [
            'order_id'  => $order->id,
            'fare' => $order->cost_best,
            'pickup_address' => $address['pickup_address'],
            'drop_address' => $address['drop_address'],
            'pickup_location' => $location['pickup_location'],
            'drop_location' => $location['drop_location'],
            'distance' => $order->distance_best *1000,
            'duration' => $order->duration_best *60,
            'pet' => $order->serviceOptions->isEmpty() ,
            'updated_at' => $order->updated_at,
            'rider' => [
                'name' => $order->rider?->user?->name ?? '',
                'mobile' => $order->rider?->user?->mobile,
                'total_ride' => (int) $order->rider?->orders?->count() ?? 0,
                'profile_picture' => $order->rider?->user?->profile_picture,
                'total_rides' => $order->rider->orders->count(),
            ]
        ];

        $title = "New Ride Available";
        $body = "There is an available ride.";
        $tokens = UserRepository::query()->where('id', $this->driverId)->whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();

        $data = [
            'type' => 'new_ride_available',
            'order_id' => $order->id,
            'order_status' => $order->status->value,
            'sent_at' => now()->toDateTimeString()
        ];
        NotificationServices::sendNotification($body, $tokens, $title, $data);
    }

    public function broadcastOn()
    {
        return new Channel('order.' . $this->driverId);
    }

    public function broadcastAs()
    {
        return 'new-ride-available-notification';
    }

    public function broadcastWith()
    {
        return [
            'message' => 'There is an available ride.',
            'data' => $this->data
        ];
    }
}
