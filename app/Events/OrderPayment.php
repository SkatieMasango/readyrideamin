<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class OrderPayment implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data, $driverId, $riderId;

    public function __construct($order, $driverId)
    {
        $address  = json_decode($order->addresses, true)  ?? [];
        $location = json_decode($order->points, true)  ?? [];

        $this->driverId = $driverId;
        $riderId = $order->rider->user_id;
        $this->riderId = $riderId;
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
                'name' => $order->rider?->user?->name,
                'mobile' => $order->rider?->user?->mobile,
                'total_ride' => (int) $order->rider?->orders?->count() ?? 0,
                'profile_picture' => $order->rider?->user?->profile_picture,
                'total_rides' => $order->rider->orders->count(),
            ]
        ];

    }


    public function broadcastOn()
    {
        return new Channel('order-cash.' . $this->riderId);
    }

    public function broadcastAs()
    {
        return 'cash-payment-notification';
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Order is completed.',
            'data' => $this->data
        ];
    }
}
