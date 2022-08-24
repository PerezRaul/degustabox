<?php

declare(strict_types=1);

namespace Src\Shared\Domain;

use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;

final class FileUtils
{
    public static function classesThatImplements(string $interface, string ...$dirs): array
    {
        if (empty($dirs)) {
            /** @var string[] $dirs */
            $dirs = config('degustabox.bus.scan_dirs');
        }

        return array_values(map(
            function ($file) {
                return Utils::fullNamespace($file->getPathname());
            },
            with(new Finder())->in($dirs)->files()->name('*.php')->filter(function (SplFileInfo $file) use ($interface
            ) {
                $classNamespace = Utils::fullNamespace($file->getPathname());

                if (null === $classNamespace) {
                    return false;
                }

                $class = new ReflectionClass($classNamespace);

                return $class->implementsInterface($interface) && $classNamespace !== $interface;
            })
        ));
    }

    public static function filesIn(string $path, string $fileType): array
    {
        $paths = scandir($path);

        if (!is_array($paths)) {
            return [];
        }

        return filter(
            static fn(string $possibleModule) => strstr($possibleModule, $fileType),
            $paths
        );
    }
}
