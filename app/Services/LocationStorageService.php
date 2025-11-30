<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class LocationStorageService
{
    public static function storeLocation($userId, $lat, $lng)
    {
        $key = "location:$userId";
        Redis::lpush($key, json_encode(['lat' => $lat, 'lng' => $lng]));

        // Trim the list to keep only the last two entries
        Redis::ltrim($key, 0, 1);
    }

    public static function getLastLocation($userId)
    {
        $locations = self::getLastTwoLocations($userId);
        if (empty($locations)) {
            return [];
        }

        return json_decode($locations[0], true);
    }

    private static function getLastTwoLocations($userId)
    {
        $key = "location:$userId";

        return Redis::lrange($key, 0, 1);
    }

    public static function calculateDirection($userId)
    {
        $locations = self::getLastTwoLocations($userId);

        if (count($locations) < 2) {
            return; // Not enough data
        }

        [$first, $second] = array_map('json_decode', $locations);

        $dy = $second->lat - $first->lat;
        $dx = $second->lng - $first->lng;

        return atan2($dy, $dx) * (180 / pi()); // Convert to degrees
    }
}
