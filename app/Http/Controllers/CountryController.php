<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Repositories\CountryRepository;

class CountryController extends Controller
{

    public function index()
    {
        $countries = CountryRepository::getAll();
        return $this->json('Country code fetch successfully', ['countries' => CountryResource::collection($countries)]);
    }


}
