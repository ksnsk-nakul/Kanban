<?php

namespace Database\Seeders\DevLife;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Core
            ['key' => 'tasks.view', 'name' => 'View tasks', 'group' => 'tasks'],
            ['key' => 'tasks.create', 'name' => 'Create tasks', 'group' => 'tasks'],
            ['key' => 'tasks.update', 'name' => 'Update tasks', 'group' => 'tasks'],
            ['key' => 'tasks.delete', 'name' => 'Delete tasks', 'group' => 'tasks'],

            ['key' => 'settings.manage', 'name' => 'Manage app settings', 'group' => 'admin'],
            ['key' => 'rbac.roles.manage', 'name' => 'Manage roles', 'group' => 'rbac'],
            ['key' => 'rbac.permissions.manage', 'name' => 'Manage permissions', 'group' => 'rbac'],
            ['key' => 'localization.languages.manage', 'name' => 'Manage languages', 'group' => 'localization'],
            ['key' => 'localization.translations.manage', 'name' => 'Manage translations', 'group' => 'localization'],
            ['key' => 'international.countries.manage', 'name' => 'Manage countries', 'group' => 'international'],

            // Placeholder groups for buyers (even if addons are not installed yet)
            ['key' => 'crm.leads.view', 'name' => 'View leads', 'group' => 'crm'],
            ['key' => 'crm.leads.create', 'name' => 'Create leads', 'group' => 'crm'],
            ['key' => 'crm.leads.update', 'name' => 'Update leads', 'group' => 'crm'],
            ['key' => 'crm.leads.delete', 'name' => 'Delete leads', 'group' => 'crm'],

            ['key' => 'hrm.employees.view', 'name' => 'View employees', 'group' => 'hrm'],
            ['key' => 'hrm.employees.create', 'name' => 'Create employees', 'group' => 'hrm'],
            ['key' => 'hrm.employees.update', 'name' => 'Update employees', 'group' => 'hrm'],
            ['key' => 'hrm.employees.delete', 'name' => 'Delete employees', 'group' => 'hrm'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(
                ['key' => $permission['key']],
                [
                    'name' => $permission['name'],
                    'group' => $permission['group'] ?? null,
                    'description' => null,
                    'is_system' => true,
                ],
            );
        }
    }
}

