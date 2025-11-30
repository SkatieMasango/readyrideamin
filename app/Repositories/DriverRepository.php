<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Driver;

class DriverRepository extends Repository
{
    public static function model()
    {
        return Driver::class;
    }

    public static function findDriver($id){
        return self::query()->where('user_id', $id)->first();
    }

    public static function updateByRequest($request, $driver): void
    {
        $vehicleColor = VehicleColorRepository::find($request->vehicle_color);
        self::update($driver, [
            'vehicle_plate' => $request->vehicle_plate,
            'vehicle_production_year' => $request->vehicle_regi_year,
            'vehicle_id' => $request->vehicle_type,
            'vehicle_color_legacy' => $vehicleColor?->name,
            'vehicle_color_id' => $request->vehicle_color,

        ]);
    }

   public static function getApprovedDrivers($status)
{
    return self::query()->with(['user' => function ($query) use ($status) {
            $query->where('status', $status);
        }])
        ->whereHas('user', function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->orderBy('created_at', 'desc')
        ->get();
}
}
