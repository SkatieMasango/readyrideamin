<?php

namespace App\Events;

use App\Models\Rider;
use App\Repositories\UserRepository;
use App\Services\NotificationServices;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class StatusEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data, $userId, $message, $orderId;

    public function __construct($order, $message, public bool $isCancelled = false)
    {
        $address  = json_decode($order->addresses, true)  ?? [];
        $this->userId = $order->rider->user_id;
        $this->orderId = $order->id;
        $this->message = $message;
        $this->data = [
            'order_id' => $order->id,
            'status' => $order->status,
            'distance' => $order->distance_best *1000,
            'duration' => $order->duration_best *60,
            'pickup_address' => $address['pickup_address'],
            'drop_address' => $address['drop_address'],
            'driver' =>  $order->when($order->driver_id, function () use ($order) {
                return [
                    'id' => $order->driver?->user?->id,
                    'name' => $order->driver?->user?->name,
                    'mobile' => $order->driver?->user?->mobile,
                    'rating' => (double) number_format($order->driver?->rating ?? 0.0, 1),
                    'total_trip' => (int) $order->driver?->orders->count() ?? 0,
                    'profile_picture' => $order->driver?->user?->profile_picture,
                    'direction' => $order->driver?->heading ?? 0,
                    'current_location' => json_decode($order->driver?->current_location) ?? null,
                ];
            }, null),
        ];

        $title = "Order Status Update";

        $tokens = UserRepository::query()->where('id', $this->userId)->whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();
        NotificationServices::sendNotification($this->message, $tokens, $title);

    }

    public function broadcastOn()
    {
        return new Channel('order.'.$this->orderId . '.' . $this->userId);
    }

    public function broadcastAs()
    {
        return match($this->isCancelled) {
            true => 'declined-looking-driver',
            default => 'status-update-notification',
        };
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
