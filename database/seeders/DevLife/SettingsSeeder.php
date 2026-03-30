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
            ['key' => 'branding', 'name' => 'Branding', 'sort_order' => 80],
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
        $this->put($groupModels['payment']->id, 'razorpay_key_id', null);
        $this->put($groupModels['payment']->id, 'razorpay_key_secret', null, 'string', true);
        $this->put($groupModels['payment']->id, 'stripe_public_key', null);
        $this->put($groupModels['payment']->id, 'stripe_secret_key', null, 'string', true);
        $this->put($groupModels['payment']->id, 'paypal_client_id', null);
        $this->put($groupModels['payment']->id, 'paypal_client_secret', null, 'string', true);

        $this->put($groupModels['sms']->id, 'gateway', 'twilio');
        $this->put($groupModels['sms']->id, 'mode', 'sandbox');
        $this->put($groupModels['sms']->id, 'twilio_sid', null);
        $this->put($groupModels['sms']->id, 'twilio_token', null, 'string', true);
        $this->put($groupModels['sms']->id, 'twilio_from', null);
        $this->put($groupModels['sms']->id, 'firebase_api_key', null, 'string', true);
        $this->put($groupModels['sms']->id, 'firebase_project_id', null);
        $this->put($groupModels['sms']->id, 'msg91_auth_key', null, 'string', true);
        $this->put($groupModels['sms']->id, 'msg91_sender_id', null);

        $this->put($groupModels['wallet']->id, 'enabled', 'true', 'bool');

        $this->put($groupModels['theme']->id, 'default_mode', 'dark');

        $this->put($groupModels['compliance']->id, 'cookie_banner_enabled', 'true', 'bool');
        $this->put($groupModels['compliance']->id, 'cookie_consent_text', 'We use necessary cookies to keep DevLife OS running.', 'string');

        $this->put($groupModels['branding']->id, 'logo_path', null);
        $this->put($groupModels['branding']->id, 'favicon_path', null);
    }

    private function put(int $groupId, string $key, ?string $value, string $type = 'string', bool $encrypted = false): void
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
                'is_encrypted' => $encrypted,
            ],
        );
    }
}
