<?php
namespace App\Repositories;

use App\Models\Complaint;
use Abedin\Maker\Repositories\Repository;
use App\Models\Country;

class CountryRepository extends Repository
{
    public static function model()
    {
        return Country::class;
    }
    /**
     * Store a new complaint based on the request data.
     *
     * @param \Illuminate\Http\Request $request
     * @return Complaint
     */

}
