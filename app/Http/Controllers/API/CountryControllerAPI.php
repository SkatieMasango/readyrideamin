<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\CountryRepository;

class CountryControllerAPI extends Controller
{

    public function getCountryCode()
    {
        $countries = CountryRepository::getAll();
        if ($countries->isEmpty()) {
                return response()->json([
                    'message' => 'No countries found',
                    'countries' => []
                ], 404);
            }
        $transformedCountries = $countries->map(function ($country) {
                $code = $country->code ? $country['code'] : null;
                $name = $country->name ? $country['name'] : null;
                $phoneCode = $country->phone_code ? $country['phone_code'] : null;
                $flag = $country->image ? $country['image'] : null;
                return [
                    'code' => $code,
                    'name' => $name,
                    'phoneCode' => $phoneCode,
                    'flag' => $flag,
                    'languageCode' => null
                ];
            })->sortBy('name')->values();

            return response()->json([
                'message' => 'Country list',
                'countries' => $transformedCountries
            ], 200);
        }


}
