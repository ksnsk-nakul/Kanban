<?php

namespace Database\Seeders\DevLife;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'level' => 100],
            ['name' => 'Admin', 'slug' => 'admin', 'level' => 50],
            ['name' => 'User', 'slug' => 'user', 'level' => 10],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(
                ['slug' => $role['slug']],
                [
                    'name' => $role['name'],
                    'level' => $role['level'],
                    'is_required' => true,
                    'is_system' => true,
                ],
            );
        }
    }
}
