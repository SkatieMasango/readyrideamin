<?php

namespace App\Console\Commands;

use App\Http\Traits\AssignDriverTrait;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AssignRideCommand extends Command
{
    use AssignDriverTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:assign-to-driver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    public function handle()
    {
	    $timestamp = now();
        $filePath = storage_path('app/cron_last_run.txt');

        File::put($filePath, $timestamp);
        Log::info('order:assign-to-driver ran at: ' . $timestamp);
        $duration = 30; // Duration in seconds
        $oreders = Order::where('status', 'pending')
            ->where('updated_at', '<', now()->subSeconds($duration)->format('Y-m-d H:i:s'))
            ->get();

        foreach ($oreders as $order) {
            $pickAddress = json_decode($order->addresses)->pickup_address;
            $this->assignOrderToDriver($order, $pickAddress);
        }
    }


}
