<?php

declare(strict_types=1);

namespace App\Providers;

use Src\Shared\Domain\StrUtils;
use Src\Shared\Domain\Utils;
use Src\Shared\Infrastructure\Laravel\Validator\Rules\Rule;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

final class ValidatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        foreach ((new Finder())->in([__DIR__ . '/../Validator/Rules'])->files() as $class) {
            $className = Utils::className($class->getPathname());
            $class     = Utils::fullNamespace($class->getPathname());

            if (null === $class) {
                continue;
            }

            $reflectionClass = new ReflectionClass($class);

            if (
                $reflectionClass->implementsInterface(Rule::class) &&
                $reflectionClass->isInstantiable()
            ) {
                /** @var Rule $class */
                $class = with(new $class());

                if (method_exists($class, 'messageReplacements')) {
                    $class->messageReplacements();
                }

                ValidatorFacade::extend(StrUtils::snake($className), function (
                    string $attribute,
                    mixed $value,
                    array $parameters,
                    Validator $validator,
                ) use ($class) {
                    return $class->passes($attribute, $value, $parameters, $validator);
                }, $class->message());
            }
        }
    }
}
