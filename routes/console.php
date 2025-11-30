<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Broadcast;


// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:notify-unaccepted-orders')->everyMinute();

Broadcast::channel('driver-status.{driverId}', function ($user, $driverId) {
    return (int) $user->id === (int) $driverId;
});


