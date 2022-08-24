<?php

declare(strict_types=1);

namespace src\Audits\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

final class AuditServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/audit.php', 'degustabox.audit');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/audit.php' => config_path('degustabox/audit.php'),
        ]);
    }
}
