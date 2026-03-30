<?php

namespace Database\Seeders\DevLife;

use App\Models\AuthMethod;
use Illuminate\Database\Seeder;

class AuthMethodsSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['key' => 'mobile_otp', 'enabled' => false, 'sort_order' => 20],
            ['key' => 'email_otp', 'enabled' => false, 'sort_order' => 30],
            ['key' => 'mobile_password', 'enabled' => false, 'sort_order' => 40],
            ['key' => 'email_password', 'enabled' => true, 'sort_order' => 10],
            ['key' => 'google', 'enabled' => false, 'sort_order' => 50],
        ];

        foreach ($methods as $method) {
            AuthMethod::query()->updateOrCreate(
                ['key' => $method['key']],
                [
                    'enabled' => $method['enabled'],
                    'sort_order' => $method['sort_order'],
                ],
            );
        }
    }
}

