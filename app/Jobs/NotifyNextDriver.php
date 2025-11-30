<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Driver;
use App\Jobs\NotifyDriver;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyNextDriver
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;
    protected $drivers;

    public function __construct($orderId, $drivers)
    {
        $this->orderId = $orderId;
        $this->drivers = $drivers;
    }

    public function handle()
    {
        $order = Order::find($this->orderId);

        if ($order->status->value !== 'accepted') {
            $onlineDrivers = [];
            $offlineDrivers = [];

            foreach ($this->drivers as $driver) {
                $realDriver = Driver::find($driver->id);

                if (!$realDriver || !$realDriver->user_id) {
                    continue;
                }

                if ($realDriver->driver_status == 'Online') {
                    $onlineDrivers[] = $realDriver;
                } else {
                    $offlineDrivers[] = $realDriver;
                }
            }

            foreach ($onlineDrivers as $index => $driver) {
                NotifyDriver::dispatch($order, $driver->user_id)
                    ->delay(now()->addMinutes(1 * $index));
            }

        }
    }
}
