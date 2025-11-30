<?php

namespace App\Services;

use App\Models\Region;
use Illuminate\Support\Facades\DB;

class RegionService
{
    public static function getRegionWithPoint($point)
    {
        $latitude = $point[0];
        $longitude = $point[1];

        $regions = DB::table('regions')->get();

        foreach ($regions as $region) {
            $coordinates = json_decode($region->polygon_coordinates, true);

            if (self::pointInPolygon($latitude, $longitude, $coordinates)) {
                return ['inside' => true, 'region' => $region];
            }
        }

        return ['inside' => false];
    }

    public static function getRegionServices($regionId)
    {
        $region = Region::with('services')->find($regionId);

        return $region ? $region->services : [];
    }

    private static function pointInPolygon($lat, $lng, $polygon)
    {
        $inside = false;
        $j = count($polygon) - 1;

        for ($i = 0; $i < count($polygon); $i++) {
            $xi = $polygon[$i]['lat'];
            $yi = $polygon[$i]['lng'];
            $xj = $polygon[$j]['lat'];
            $yj = $polygon[$j]['lng'];

            $intersect = (($yi > $lng) != ($yj > $lng)) &&
                ($lat < ($xj - $xi) * ($lng - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = ! $inside;
            }
            $j = $i;
        }

        return $inside;
    }
}
