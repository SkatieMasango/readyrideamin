<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\ServiceOption;

class ServiceOptionRepository extends Repository
{
    public static function model()
    {
        return ServiceOption::class;    
    }
}