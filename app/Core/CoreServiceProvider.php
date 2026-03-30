<?php

namespace App\Core;

use App\Core\Addons\AddonManager;
use App\Core\Auth\AuthManager;
use App\Core\Auth\AuthPipeline;
use App\Core\Auth\Drivers\EmailPasswordAuthMethod;
use App\Core\Console\Commands\MakeAddonCommand;
use App\Core\Settings\SettingsManager;
use Illuminate\Support\ServiceProvider;

final class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AddonManager::class);
        $this->app->singleton(SettingsManager::class);
        $this->app->singleton(AuthManager::class, function () {
            return new AuthManager([
                new EmailPasswordAuthMethod(),
            ]);
        });
        $this->app->singleton(AuthPipeline::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeAddonCommand::class,
            ]);
        }
    }

    public function boot(AddonManager $addons): void
    {
        $addons->registerEnabledAddons($this->app);
    }
}
