<?php

namespace Database\Seeders\DevLife;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'admin@devlife.test'],
            [
                'name' => 'DevLife Admin',
                'password' => Hash::make('password'),
                'theme_mode' => 'dark',
                'stage' => 'learning',
                'locale' => 'en',
            ],
        );

        $role = Role::query()->where('slug', 'super-admin')->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->getKey()]);
        }
    }
}

