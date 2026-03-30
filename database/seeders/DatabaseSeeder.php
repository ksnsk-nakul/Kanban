<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\DevLife\AuthMethodsSeeder;
use Database\Seeders\DevLife\CountriesSeeder;
use Database\Seeders\DevLife\CurrenciesSeeder;
use Database\Seeders\DevLife\DemoUserSeeder;
use Database\Seeders\DevLife\LanguagesSeeder;
use Database\Seeders\DevLife\PermissionsSeeder;
use Database\Seeders\DevLife\RolesSeeder;
use Database\Seeders\DevLife\SettingsSeeder;
use Database\Seeders\DevLife\TranslationsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
            AuthMethodsSeeder::class,
            LanguagesSeeder::class,
            CountriesSeeder::class,
            CurrenciesSeeder::class,
            SettingsSeeder::class,
            TranslationsSeeder::class,
            DemoUserSeeder::class,
        ]);
    }
}
