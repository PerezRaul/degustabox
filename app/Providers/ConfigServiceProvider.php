<?php

declare(strict_types=1);

namespace App\Providers;

use Src\Shared\Domain\Config\Config;
use Src\Shared\Infrastructure\Config\LaravelConfig;
use Illuminate\Support\ServiceProvider;

final class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Config::class, function ($app) {
            return $app->make(LaravelConfig::class);
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'shared.config');
    }
}
