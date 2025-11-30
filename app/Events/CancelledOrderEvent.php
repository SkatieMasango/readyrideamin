<?php

namespace App\Events;

use App\Repositories\UserRepository;
use App\Services\NotificationServices;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CancelledOrderEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public $orderId, public $userId)
    {
        $title = "Order Cancelled";
        $body = "We are sorry, the order has been cancelled.";
        $tokens = UserRepository::query()->where('id', $this->userId)->whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();
        NotificationServices::sendNotification($body, $tokens, $title);
    }

/**
 * Get the channels the event should broadcast on.
 *
 * @return \Illuminate\Broadcasting\Channel|array
 */
    public function broadcastOn()
    {
         return new Channel('order.'.$this->orderId . '.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'cancelled-order-notification';
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->orderId,
            'message' => 'We are sorry, the driver is not available at the moment.',
        ];
    }



}
