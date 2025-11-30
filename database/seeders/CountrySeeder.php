<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countriesJson = file_get_contents(database_path('data/countries.json'));

        $countries = json_decode($countriesJson, true);

        foreach ($countries as $country) {
            $image = "https://flagcdn.com/w320/" . strtolower($country['iso']['alpha-2']) . ".png";
            Country::create([
                'name' => $country['name'],
                'code' => $country['iso']['alpha-2'],
                'phone_code' => $country['phone'][0],
                'image' => $image,

            ]);
        }
    }
}
