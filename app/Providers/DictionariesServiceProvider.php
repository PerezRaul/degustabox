<?php

declare(strict_types=1);

namespace App\Providers;

use Src\Shared\Domain\Dictionaries\UuidDictionary;
use Illuminate\Support\ServiceProvider;

final class DictionariesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UuidDictionary::class, function () {
            return new UuidDictionary();
        });
    }
}
