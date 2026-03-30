<?php

namespace App\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class MakeAddonCommand extends Command
{
    protected $signature = 'make:addon
                            {name : Addon name (e.g. CRM, PortfolioBuilder)}
                            {--slug= : Addon slug override (e.g. portfolio-builder)}
                            {--disabled : Create addon with enabled=false}
                            {--force : Overwrite existing addon directory}';

    protected $description = 'Create a new addon in /Addons (routes, migrations, views scaffolding)';

    public function handle(Filesystem $files): int
    {
        $name = Str::studly((string) $this->argument('name'));
        $slug = (string) ($this->option('slug') ?: Str::kebab($name));
        $enabled = !(bool) $this->option('disabled');

        $addonRoot = base_path("Addons/{$name}");

        if ($files->exists($addonRoot)) {
            if (!$this->option('force')) {
                $this->components->error("Addon directory already exists: {$addonRoot}");
                $this->components->info('Re-run with --force to overwrite.');
                return self::FAILURE;
            }

            $files->deleteDirectory($addonRoot);
        }

        $files->ensureDirectoryExists($addonRoot);
        $files->ensureDirectoryExists("{$addonRoot}/Providers");
        $files->ensureDirectoryExists("{$addonRoot}/Routes");
        $files->ensureDirectoryExists("{$addonRoot}/Database/Migrations");
        $files->ensureDirectoryExists("{$addonRoot}/Resources/views");

        $providerClass = "Addons\\\\{$name}\\\\Providers\\\\{$name}AddonServiceProvider";

        $files->put("{$addonRoot}/addon.php", $this->renderManifest($name, $slug, $enabled, $providerClass));
        $files->put("{$addonRoot}/Providers/{$name}AddonServiceProvider.php", $this->renderProvider($name));
        $files->put("{$addonRoot}/Routes/web.php", $this->renderWebRoutes($name));
        $files->put("{$addonRoot}/Resources/views/.gitkeep", '');

        $this->components->info("Addon created: {$name}");
        $this->line("- Path: {$addonRoot}");
        $this->line("- Provider: {$providerClass}");
        $this->line("- Slug: {$slug}");

        return self::SUCCESS;
    }

    private function renderManifest(string $name, string $slug, bool $enabled, string $providerClass): string
    {
        $enabledPhp = $enabled ? 'true' : 'false';

        return <<<PHP
<?php

return [
    'name' => '{$name}',
    'slug' => '{$slug}',
    'enabled' => {$enabledPhp},
    'provider' => '{$providerClass}',
];

PHP;
    }

    private function renderProvider(string $name): string
    {
        return <<<PHP
<?php

namespace Addons\\{$name}\\Providers;

use App\\Core\\Addons\\AddonServiceProvider;

final class {$name}AddonServiceProvider extends AddonServiceProvider
{
    public function register(): void
    {
        //
    }
}

PHP;
    }

    private function renderWebRoutes(string $name): string
    {
        $slug = Str::kebab($name);

        return <<<PHP
<?php

use Illuminate\\Support\\Facades\\Route;

Route::middleware('web')
    ->prefix('addons/{$slug}')
    ->group(function () {
        // Addon routes go here.
    });

PHP;
    }
}

