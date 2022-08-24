<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cache.php', 'cache');

    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/cache.php' => config_path('cache.php'),
        ]);
    }
}
