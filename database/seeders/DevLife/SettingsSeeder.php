<?php

namespace Database\Seeders\DevLife;

use App\Models\Setting;
use App\Models\SettingsGroup;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['key' => 'general', 'name' => 'General', 'sort_order' => 10],
            ['key' => 'auth', 'name' => 'Authentication', 'sort_order' => 20],
            ['key' => 'payment', 'name' => 'Payments', 'sort_order' => 30],
            ['key' => 'sms', 'name' => 'SMS', 'sort_order' => 40],
            ['key' => 'wallet', 'name' => 'Wallet', 'sort_order' => 50],
            ['key' => 'theme', 'name' => 'Theme', 'sort_order' => 60],
            ['key' => 'compliance', 'name' => 'Compliance', 'sort_order' => 70],
        ];

        $groupModels = [];
        foreach ($groups as $group) {
            $groupModels[$group['key']] = SettingsGroup::query()->updateOrCreate(
                ['key' => $group['key']],
                [
                    'name' => $group['name'],
                    'description' => null,
                    'sort_order' => $group['sort_order'],
                ],
            );
        }

        $this->put($groupModels['general']->id, 'default_language', 'en');
        $this->put($groupModels['general']->id, 'default_country_iso2', null);
        $this->put($groupModels['general']->id, 'default_currency_code', null);

        $this->put($groupModels['auth']->id, 'enabled_methods', json_encode(['email_password']), 'json');
        $this->put($groupModels['auth']->id, 'google_enabled', 'false', 'bool');

        $this->put($groupModels['payment']->id, 'gateway', 'razorpay');
        $this->put($groupModels['payment']->id, 'mode', 'sandbox');

        $this->put($groupModels['sms']->id, 'gateway', 'twilio');
        $this->put($groupModels['sms']->id, 'mode', 'sandbox');

        $this->put($groupModels['wallet']->id, 'enabled', 'true', 'bool');

        $this->put($groupModels['theme']->id, 'default_mode', 'light');

        $this->put($groupModels['compliance']->id, 'cookie_banner_enabled', 'true', 'bool');
    }

    private function put(int $groupId, string $key, ?string $value, string $type = 'string'): void
    {
        Setting::query()->updateOrCreate(
            [
                'settings_group_id' => $groupId,
                'key' => $key,
            ],
            [
                'value' => $value,
                'type' => $type,
                'is_public' => false,
                'is_encrypted' => false,
            ],
        );
    }
}

