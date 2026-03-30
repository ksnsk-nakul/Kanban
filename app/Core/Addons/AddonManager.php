<?php

namespace App\Core\Addons;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class AddonManager
{
    public function __construct(private readonly Filesystem $files)
    {
    }

    /**
     * @return array<int, Addon>
     */
    public function discover(): array
    {
        $addonsPath = (string) config('devlife.addons.path', base_path('Addons'));

        if (!$this->files->isDirectory($addonsPath)) {
            return [];
        }

        $directories = $this->files->directories($addonsPath);
        sort($directories);

        $addons = [];

        foreach ($directories as $addonPath) {
            $defaultName = basename($addonPath);
            $manifest = $this->loadManifest($addonPath);

            $name = (string) ($manifest['name'] ?? $defaultName);
            $slug = (string) ($manifest['slug'] ?? Str::kebab($name));
            $enabled = (bool) ($manifest['enabled'] ?? true);
            $providerClass = $manifest['provider'] ?? null;

            if (!is_string($providerClass) || $providerClass === '') {
                $providerClass = $this->defaultProviderClassFor($name);
            }

            $addons[] = new Addon(
                name: $name,
                slug: $slug,
                path: $addonPath,
                enabled: $enabled,
                providerClass: $providerClass,
            );
        }

        return $addons;
    }

    /**
     * @return array<int, Addon>
     */
    public function enabledAddons(): array
    {
        $overrides = (array) config('devlife.addons.enabled', []);
        $overrides = Arr::where($overrides, fn ($value) => is_bool($value));

        $enabled = [];

        foreach ($this->discover() as $addon) {
            $override = $overrides[$addon->slug] ?? $overrides[$addon->name] ?? null;

            if (is_bool($override)) {
                $addon->enabled = $override;
            }

            if (!$addon->enabled) {
                continue;
            }

            $enabled[] = $addon;
        }

        return $enabled;
    }

    public function registerEnabledAddons(Application $app): void
    {
        foreach ($this->enabledAddons() as $addon) {
            if (!is_string($addon->providerClass) || $addon->providerClass === '') {
                continue;
            }

            if (!class_exists($addon->providerClass)) {
                continue;
            }

            $app->register($addon->providerClass);
        }
    }

    private function loadManifest(string $addonPath): array
    {
        $phpManifestPath = $addonPath . DIRECTORY_SEPARATOR . 'addon.php';
        if ($this->files->isFile($phpManifestPath)) {
            $data = require $phpManifestPath;
            return is_array($data) ? $data : [];
        }

        $jsonManifestPath = $addonPath . DIRECTORY_SEPARATOR . 'addon.json';
        if ($this->files->isFile($jsonManifestPath)) {
            $decoded = json_decode((string) $this->files->get($jsonManifestPath), true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    private function defaultProviderClassFor(string $addonName): string
    {
        $addonName = Str::studly($addonName);

        return "Addons\\{$addonName}\\Providers\\{$addonName}AddonServiceProvider";
    }
}

