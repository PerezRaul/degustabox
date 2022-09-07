<?php

declare(strict_types=1);

namespace App\Console\Bus\Event\RabbitMq;

use Illuminate\Console\Command;
use Src\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use Src\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqDomainEventsConsumer;

use function Lambdish\Phunctional\repeat;

final class ConsumeRabbitMqDomainEventsCommand extends Command
{
    protected $signature   = 'time-tracker:domain-events:rabbitmq:consume
        {queue : Queue name}
        {quantity : Quantity of events to process}
    ';
    protected $description = 'Consume domain events from the RabbitMQ';

    public function handle(): void
    {
        /** @var string $queueName */
        $queueName       = $this->argument('queue');
        $eventsToProcess = (int) $this->argument('quantity');

        repeat($this->consumer($queueName), $eventsToProcess);

        $this->info(sprintf('Consumed events on %s queue', $queueName));
    }

    private function consumer(string $queueName): callable
    {
        return function () use ($queueName) {
            /** @var callable $subscriber */
            $subscriber = app(DomainEventSubscriberLocator::class)->withRabbitMqQueueNamed($queueName);

            app(RabbitMqDomainEventsConsumer::class)->consume($subscriber, $queueName);
        };
    }
}
