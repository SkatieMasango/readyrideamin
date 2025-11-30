<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Driver;
use App\Events\NewRideAvailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyDriver implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $userId;

    public function __construct(Order $order, $userId)
    {
        $this->order = $order;
        $this->userId = $userId;
    }

    public function handle()
    {
        if($this->order->status->value ==  'accepted') {
            return;
        }else{
            event(new NewRideAvailable($this->order, $this->userId));

        }
    }
}

