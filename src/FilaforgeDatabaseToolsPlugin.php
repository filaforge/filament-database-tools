<?php

namespace Filaforge\DatabaseTools;

use Filament\Contracts\Plugin as PluginContract;
use Filament\Panel;

class FilaforgeDatabaseToolsPlugin implements PluginContract
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'database-tools';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            \Filaforge\DatabaseTools\Pages\DatabaseTools::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
