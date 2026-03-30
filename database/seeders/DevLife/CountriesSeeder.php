<?php

namespace Database\Seeders\DevLife;

use App\Models\Country;
use Illuminate\Database\Seeder;
use League\ISO3166\ISO3166;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        $iso = new ISO3166();

        foreach ($iso->all() as $row) {
            Country::query()->updateOrCreate(
                ['iso2' => $row['alpha2']],
                [
                    'iso3' => $row['alpha3'] ?? null,
                    'name' => $row['name'],
                    'active' => false,
                    'currency_code' => null,
                ],
            );
        }
    }
}

