<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $jsonPath = database_path('seeders/data/country_by_currency_code.json');

        if (File::exists($jsonPath)) {
            $jsonData = File::get($jsonPath);
            $merchantCategoryCodes = json_decode($jsonData, true);

            if (is_array($merchantCategoryCodes)) {
                Currency::insert(
                    array_map(fn ($item) => [
                        'country' => $item['country'],
                        'currency_code' => $item['currency_code'],
                    ], $merchantCategoryCodes)
                );
            }
        }
    }
}
