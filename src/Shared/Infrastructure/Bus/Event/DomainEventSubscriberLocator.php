<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Bus\Event;

use Src\Shared\Domain\ArrUtils;
use Src\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Src\Shared\Domain\Bus\Event\ShouldNotQueue;
use Src\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Src\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;
use RuntimeException;
use Traversable;

use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\search;

final class DomainEventSubscriberLocator
{
    private array $mappingArray;

    public function __construct(private Traversable $mapping)
    {
    }

    public function mappingArray(): array
    {
        return $this->mappingArray = $this->mappingArray ?? iterator_to_array($this->mapping);
    }

    public function allSubscribedTo(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mappingArray());

        /** @var array $allSubscribedTo */
        $allSubscribedTo = ArrUtils::get($formatted, $eventClass, []);

        return $allSubscribedTo;
    }

    public function allShouldNotQueueSubscribedTo(string $eventClass): array
    {
        return filter(function (DomainEventSubscriber $subscriber) {
            return is_subclass_of($subscriber, ShouldNotQueue::class);
        }, $this->allSubscribedTo($eventClass));
    }

    public function withRabbitMqQueueNamed(string $queueName): DomainEventSubscriber|callable
    {
        /** @var DomainEventSubscriber|null $subscriber */
        $subscriber = search(
            static fn(DomainEventSubscriber $subscriber) => RabbitMqQueueNameFormatter::format($subscriber) ===
                $queueName,
            $this->mappingArray()
        );

        if (null === $subscriber) {
            throw new RuntimeException("There are no subscribers for the <$queueName> queue");
        }

        return $subscriber;
    }

    public function allShouldQueue(): array
    {
        return filter(function (DomainEventSubscriber $subscriber) {
            return !is_subclass_of($subscriber, ShouldNotQueue::class);
        }, $this->mappingArray());
    }

    public function all(): array
    {
        return $this->mappingArray();
    }
}
