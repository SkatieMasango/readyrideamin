<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Service;

class ServiceRepository extends Repository
{
    public static function model()
    {
        return Service::class;
    }

    public static function calculateFare(int $serviceId, $distance, $duration, $waitTime = 0, $couponCode = null)
    {
        $service = self::find($serviceId);
        $fare = ($distance / $service->per_hundred_meters) * $service->base_fare;
        return $fare;
        // $fare = ($service->per_hundred_meters * $distance / 100) + ($service->per_minute_drive * $duration / 60);

        // return round($fare);
    }
}
