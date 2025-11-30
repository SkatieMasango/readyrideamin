<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DriverService
{
    public static function updateLocation($driverId, $latitude, $longitude)
    {
        $driver = Driver::query()->findOrFail($driverId);
        $location = json_decode($driver->location);
        $previousLatitude = $location['lat'];
        $previousLongitude = $location['lng'];

        $driver->current_location = [
            'lat' => $latitude,
            'lng' => $longitude,
        ];
        if ($previousLatitude && $previousLongitude) {
            $direction = self::getDriverDirection($previousLatitude, $previousLongitude, $latitude, $longitude);
        }
        $driver->heading = $direction;
        $driver->save();
    }

    public static function getNearbyDrivers($lat, $lng, $radius = 2): array
    {
        $numDrivers = 10;
        $drivers = [];

        for ($i = 0; $i < $numDrivers; $i++) {
            $randomLocation = self::generateRandomLocation($lat, $lng, $radius);
            $drivers[] = [
                'id' => $i,
                'name' => 'Driver '.($i + 1),
                'latitude' => $randomLocation['latitude'],
                'longitude' => $randomLocation['longitude'],
                'vehicle_angle' => rand(0, 360),
                'available' => true,
            ];
        }

        return $drivers;
    }

    public static function findNearbyDrivers($latitude, $longitude, $radius = 50000)
    {
        // Radius in kilometers (because 1 km = 1000 meters)
        $radiusInKilometers = $radius / 50000;

        $drivers = DB::table('drivers')
            ->selectRaw('
            id, current_location, heading, rating,
            JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS lat,
            JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lng")) AS lng,
            (6371 * acos(cos(radians(?)) * cos(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS DECIMAL(10,6))))
            * cos(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lng")) AS DECIMAL(10,6))) - radians(?)) + sin(radians(?))
            * sin(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS DECIMAL(10,6)))))) AS distance
        ', [$latitude, $longitude, $latitude])
            ->where('driver_status', 'Online')
            ->where('on_trip', false)
            ->whereNull('deleted_at')
            // ->having('distance', '<=', $radius)
            // ->having('distance', '<=', $radiusInKilometers)
            ->orderBy('distance', 'asc')
            ->limit(5)
            ->get();

        return $drivers;
    }

    public static function findNearestDriver($latitude, $longitude, $radius = 50000)
    {
        $driver = DB::table('drivers')
            ->selectRaw('
            id, current_location, heading,
            JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS lat,
            JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lng")) AS lng,
            (6371 * acos(cos(radians(?)) * cos(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS DECIMAL(10,6))))
            * cos(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lng")) AS DECIMAL(10,6))) - radians(?)) + sin(radians(?))
            * sin(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS DECIMAL(10,6)))))) AS distance
        ', [$latitude, $longitude, $latitude])
            ->where('driver_status', 'Online')
            ->having('distance', '<=', $radius)
            ->where('on_trip', false)
            ->orderBy('distance', 'asc')
            ->first(); // Only get one nearest driver

        return $driver;
    }

    //new features
    public static function findNearestDriverWeb($latitude, $longitude, $radius = 50000)
    {
        return DB::table('drivers')
            ->selectRaw('
                id, current_location, heading,
                JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS lat,
                JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lng")) AS lng,
                (6371 * acos(cos(radians(?)) * cos(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS DECIMAL(10,6))))
                * cos(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lng")) AS DECIMAL(10,6))) - radians(?)) + sin(radians(?))
                * sin(radians(CAST(JSON_UNQUOTE(JSON_EXTRACT(current_location, "$.lat")) AS DECIMAL(10,6)))))) AS distance
            ', [$latitude, $longitude, $latitude])
            ->where('driver_status', 'Online')
            ->where('on_trip', false)
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc')
            ->get(); // ✅ This returns all nearby drivers
    }

    private static function generateRandomLocation($lat, $lng, $radius)
    {
        // Earth radius in km
        $earthRadius = 6371;
        $radius /= $earthRadius; // Convert radius to radians

        // Generate random angle and distance
        $angle = mt_rand(0, 360);
        $distance = sqrt(mt_rand() / mt_getrandmax()) * $radius;

        // Convert polar to vehicletesian coordinates
        $latOffset = $distance * cos(deg2rad($angle));
        $lngOffset = $distance * sin(deg2rad($angle)) / cos(deg2rad($lat));

        return [
            'latitude' => $lat + rad2deg($latOffset),
            'longitude' => $lng + rad2deg($lngOffset),
        ];
    }

    public static function getDriverDirection($previousLat, $previousLng, $currentLat, $currentLng)
    {
        // 0° = North, 90° = East, 180° = South, 270° = West
        $lat1 = deg2rad($previousLat);
        $lng1 = deg2rad($previousLng);
        $lat2 = deg2rad($currentLat);
        $lng2 = deg2rad($currentLng);

        $dLng = $lng2 - $lng1;

        $y = sin($dLng) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLng);

        $angle = rad2deg(atan2($y, $x));

        return ($angle + 360) % 360; // Normalize to 0-360 degrees
    }

    public function radiusUpdate($request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;

            $driver = Driver::where('user_id', $userId)->first();
            $driver->update([
                'radius_in_meter' => $request->radius_in_meter,
            ]);

            $user['radius_in_meter'] = $driver->radius_in_meter;
            $user['driver_status'] = $driver->driver_status;

            return successResponse(['user' => $user], 'Driver available radius updated successfully', 200);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return errorResponse('Something went wrong.');
        }
    }


     public function uploadDocuments($request)
    {
        try {
            $user = Auth::user();
            $uploadedFiles = [];
            $documentTypes = array_keys($request->file('documents'));
        //    $documentTypes = array_merge(['profile_picture'], $documentType);
            foreach ($documentTypes as $type) {
                 $fileKey = "documents.$type";

                if ( $request->hasFile($fileKey)) {
                    $existingDocuments = $user->documents()->where('type', $type)->get();
                    foreach ($existingDocuments as $existingDocument) {
                        Storage::disk('public')->delete($existingDocument->path);
                        $existingDocument->delete();
                    }

                    $files = is_array($request->file($fileKey)) ? $request->file($fileKey) : [$request->file($fileKey)];

                    foreach ($files as $file) {

                        $filePath = $file->store($type, 'public');
                        $document = new Media([
                            'name' => $file->getClientOriginalName(),
                            'path' => $filePath,
                            'type' => $type,
                            'mime_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                        ]);
                        $user->documents()->save($document);
                        $uploadedFiles[$type] = asset('storage/'.$filePath);

                    }
                }
            }

            if (empty($uploadedFiles)) {
                return errorResponse('No files were uploaded.', 400);
            }
            return $uploadedFiles;

        } catch (\Throwable $th) {
            return errorResponse('Something went wrong.', 500);
        }
    }

}
