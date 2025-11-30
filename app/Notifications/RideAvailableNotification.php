<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RideAvailableNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via()
    {
        return ['database'];
    }

    public function toArray()
    {
        return [
            'order_id' => $this->order->id,
            'pickup_location' => $this->order->pickup_location,
            'message' => 'New ride available near you',
        ];
    }
}
