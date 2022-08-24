<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Bus\Event\RabbitMq;

use AMQPException;
use Src\Shared\Domain\Bus\Event\DomainEvent;
use Src\Shared\Domain\Bus\Event\EventBus;
use Src\Shared\Infrastructure\Bus\Event\DomainEventJsonSerializer;
use Src\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use Src\Shared\Infrastructure\Bus\Event\InMemory\InMemorySymfonyEventBus;
use Src\Shared\Infrastructure\Bus\Event\Mysql\MysqlLaravelEventBus;

use function Lambdish\Phunctional\each;

final class RabbitMqEventBus implements EventBus
{
    public function __construct(
        private RabbitMqConnection $connection,
        private string $exchangeName,
        private MysqlLaravelEventBus $mysqlPublisher,
        private DomainEventSubscriberLocator $subscriberLocator,
    ) {
    }

    public function publish(DomainEvent ...$events): void
    {
        each($this->publisher(), $events);
    }

    private function publisher(): callable
    {
        return function (DomainEvent $event) {
            try {
                $this->publishEvent($event);

                $inMemoryBus = new InMemorySymfonyEventBus(
                    $this->subscriberLocator->allShouldNotQueueSubscribedTo(get_class($event)),
                    $this->mysqlPublisher,
                );
                $inMemoryBus->publish($event);
            } catch (AMQPException $error) {
                $this->mysqlPublisher->publish($event);
            }
        };
    }

    private function publishEvent(DomainEvent $event): void
    {
        $body       = DomainEventJsonSerializer::serialize($event);
        $routingKey = $event::eventName();
        $messageId  = $event->eventId();

        $this->connection->exchange($this->exchangeName)->publish(
            $body,
            $routingKey,
            AMQP_NOPARAM,
            [
                'message_id'       => $messageId,
                'content_type'     => 'application/json',
                'content_encoding' => 'utf-8',
            ]
        );
    }
}
