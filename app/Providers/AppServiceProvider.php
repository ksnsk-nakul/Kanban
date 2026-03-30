<?php

namespace App\Providers;

use App\Core\Settings\SettingObserver;
use App\Models\Setting;
use App\Core\Localization\TranslationObserver;
use App\Models\Translation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Setting::observe(SettingObserver::class);
        Translation::observe(TranslationObserver::class);
    }
}
