<?php

namespace App\Core\Settings;

use App\Models\Setting;

final class SettingObserver
{
    public function saved(Setting $setting): void
    {
        app(SettingsManager::class)->clearCache();
    }

    public function deleted(Setting $setting): void
    {
        app(SettingsManager::class)->clearCache();
    }
}

