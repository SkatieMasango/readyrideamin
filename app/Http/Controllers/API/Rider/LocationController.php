<?php

namespace App\Http\Controllers\API\Rider;

use App\Http\Controllers\Controller;
use App\Services\LocationStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $locations = LocationStorageService::getLastLocation(userId: $userId);

        return $this->json('Get location successfully', [
            'locations' => $locations,
        ]);
    }

    public function getWithDirection()
    {
        $userId = Auth::id();

        return $this->json('Get location with direction successfully', [
            'locations' => LocationStorageService::getLastLocation(userId: $userId),
            'direction' => LocationStorageService::calculateDirection(userId: $userId),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|array',
        ]);

        $userId = Auth::id();
        $lat = $request->input('location')[0];
        $lng = $request->input('location')[1];

        LocationStorageService::storeLocation(userId: $userId, lat: $lat, lng: $lng);

        return $this->json(message: 'Location stored successfully');
    }

}
