<?php

declare(strict_types=1);

namespace App\Console\Bus\Event\RabbitMq;

use Illuminate\Console\Command;
use InvalidArgumentException;
use RuntimeException;
use Src\Shared\Domain\ArrUtils;
use Src\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;

final class ConfigureRabbitMqCommand extends Command
{
    protected $signature   = 'time-tracker:domain-events:rabbitmq:configure';
    protected $description = 'Configure the RabbitMQ to allow publish & consume domain events';

    public function handle(): void
    {
        $exchange = $this->getExchangeName();

        app(RabbitMqConfigurer::class)->configure(
            $exchange,
            ...ArrUtils::iteratorToArray(app()->tagged('domain_event_should_queue_subscriber'))
        );

        $this->info('Configured successfully');
    }

    private function getExchangeName(): string
    {
        $connection    = strval(config('time-tracker.bus.event.connection'));
        $configuration = config('time-tracker.bus.event.connections.' . $connection);

        if (null === $configuration || !is_array($configuration)) {
            throw new RuntimeException(
                sprintf('No configuration found for event bus connection [%s]', $connection)
            );
        }

        switch ($configuration['driver']) {
            case 'rabbitmq':
                return $configuration['exchange'];
        }

        throw new InvalidArgumentException(
            sprintf('Unsupported event bus connection driver [%s]', $configuration['driver'])
        );
    }
}
