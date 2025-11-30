<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\VehicleColor;

class VehicleColorRepository extends Repository
{
    public static function model()
    {
        return VehicleColor::class;
    }
}
