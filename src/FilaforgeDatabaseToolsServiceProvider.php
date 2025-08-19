<?php

namespace Filaforge\DatabaseTools;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilaforgeDatabaseToolsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'database-tools';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasConfig();
    }

    public function packageBooted(): void
    {
        // Register CSS assets
        FilamentAsset::register([
            Css::make('database-tools', __DIR__ . '/../resources/css/database-tools.css'),
        ], 'filaforge/database-tools');
    }
}
