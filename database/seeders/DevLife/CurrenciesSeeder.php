<?php

namespace Database\Seeders\DevLife;

use Alcohol\ISO4217;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    public function run(): void
    {
        $iso = new ISO4217();

        foreach ($iso->getAll() as $row) {
            Currency::query()->updateOrCreate(
                ['code' => $row['alpha3']],
                [
                    'name' => $row['name'],
                    'symbol' => null,
                    'decimals' => (int) ($row['exp'] ?? 2),
                    'active' => false,
                ],
            );
        }
    }
}

