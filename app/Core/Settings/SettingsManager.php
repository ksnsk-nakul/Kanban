<?php

namespace App\Core\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

final class SettingsManager
{
    private const CACHE_KEY = 'devlife.settings.v1';

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return Setting::query()
                ->with('group')
                ->get()
                ->mapWithKeys(function (Setting $setting): array {
                    $fullKey = $setting->group->key . '.' . $setting->key;

                    return [$fullKey => $this->castValue($setting->type, $setting->value)];
                })
                ->all();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function castValue(string $type, ?string $value): mixed
    {
        return match ($type) {
            'bool' => filter_var($value, FILTER_VALIDATE_BOOL),
            'int' => is_numeric($value) ? (int) $value : null,
            'json' => is_string($value) ? json_decode($value, true) : null,
            default => $value,
        };
    }
}

