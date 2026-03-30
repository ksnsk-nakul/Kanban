<?php

namespace App\Core\Addons;

use Illuminate\Support\ServiceProvider;

abstract class AddonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $basePath = $this->addonBasePath();

        $webRoutes = $basePath . '/Routes/web.php';
        if (is_file($webRoutes)) {
            $this->loadRoutesFrom($webRoutes);
        }

        $apiRoutes = $basePath . '/Routes/api.php';
        if (is_file($apiRoutes)) {
            $this->loadRoutesFrom($apiRoutes);
        }

        $migrations = $basePath . '/Database/Migrations';
        if (is_dir($migrations)) {
            $this->loadMigrationsFrom($migrations);
        }

        $views = $basePath . '/Resources/views';
        if (is_dir($views)) {
            $this->loadViewsFrom($views, $this->addonViewNamespace());
        }
    }

    protected function addonBasePath(): string
    {
        $providerFile = (new \ReflectionClass($this))->getFileName() ?: '';

        return dirname($providerFile, 2);
    }

    protected function addonViewNamespace(): string
    {
        $basePath = $this->addonBasePath();

        return basename($basePath);
    }
}

