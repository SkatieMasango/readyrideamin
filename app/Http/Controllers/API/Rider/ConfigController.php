<?php

namespace App\Http\Controllers\API\Rider;

use App\Http\Controllers\Controller;
use App\Models\ServiceOption;
use App\Models\VehicleColor;
use App\Models\VehicleModel;

class ConfigController extends Controller
{
    public function preference(){
        $serviceOptions = ServiceOption::query()->get(['id as value', 'name']);
        return $this->json(message: 'Information', data:  $serviceOptions);
    }

    public function vehicleDetails()
    {
        return $this->json( message: 'Information', data: VehicleModel::select(['id', 'name'])->get());
    }

    public function vehicleColorDetails()
    {
        return $this->json( message: 'Information', data: VehicleColor::select(['id', 'name'])->get());
    }
}
