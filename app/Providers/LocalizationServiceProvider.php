<?php

namespace App\Providers;

use App\Core\Localization\DbTranslationLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new DbTranslationLoader(
                $app->make(Filesystem::class),
                $app['path.lang'],
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
