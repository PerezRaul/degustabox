<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Bus\Event\RabbitMq;

use Src\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Src\Shared\Domain\StrUtils;

use function Lambdish\Phunctional\last;
use function Lambdish\Phunctional\map;

final class RabbitMqQueueNameFormatter
{
    public static function format(DomainEventSubscriber $subscriber): string
    {
        $subscriberClassPaths = explode('\\', get_class($subscriber));

        $queueNameParts = [
            $subscriberClassPaths[0],
            $subscriberClassPaths[1],
            $subscriberClassPaths[2],
            last($subscriberClassPaths),
        ];

        return implode('.', map(self::toSnakeCase(), $queueNameParts));
    }

    public static function formatLater(DomainEventSubscriber $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "later.$queueName";
    }

    public static function formatRetry(DomainEventSubscriber $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "retry.$queueName";
    }

    public static function formatDeadLetter(DomainEventSubscriber $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "dead_letter.$queueName";
    }

    public static function shortFormat(DomainEventSubscriber $subscriber): string
    {
        $subscriberCamelCaseName = strval(last(explode('\\', get_class($subscriber))));

        return StrUtils::snake($subscriberCamelCaseName);
    }

    private static function toSnakeCase(): callable
    {
        return static fn(string $text) => StrUtils::snake($text);
    }
}
