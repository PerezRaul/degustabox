<?php

declare(strict_types=1);

namespace App\Console\Bus\Event\RabbitMq;

use Illuminate\Console\Command;
use Src\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Src\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use Src\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;

use function Lambdish\Phunctional\each;

final class GenerateSupervisorRabbitMqConsumerFilesCommand extends Command
{
    protected $signature   = 'time-tracker:domain-events:rabbitmq:generate-supervisor-files
        {events=100 : Events to process at time}
        {processes=1 : Nuber of processes per subscriber}
    ';
    protected $description = 'Generate the supervisor configuration for every RabbitMQ subscriber';


    public function handle(): void
    {
        if (null === env('SUPERVISORD_COMMAND_PATH')) {
            $this->error('SUPERVISORD_COMMAND_PATH env not configured');

            return;
        }

        if (null === env('SUPERVISORD_CONF_PATH')) {
            $this->error('SUPERVISORD_CONF_PATH env not configured');

            return;
        }

        $supervisordConfPath = strval(env('SUPERVISORD_CONF_PATH'));
        if (!is_dir($supervisordConfPath)) {
            mkdir($supervisordConfPath, 0777, true);
        }

        each($this->configCreator(), app(DomainEventSubscriberLocator::class)->allShouldQueue());

        $this->info('Supervisord conf files generated');
    }

    private function configCreator(): callable
    {
        return function (DomainEventSubscriber $subscriber) {
            $queueName      = RabbitMqQueueNameFormatter::format($subscriber);
            $subscriberName = RabbitMqQueueNameFormatter::shortFormat($subscriber);

            $fileContent = str_replace(
                [
                    '{subscriber_name}',
                    '{queue_name}',
                    '{path}',
                    '{processes}',
                    '{events_to_process}',
                ],
                [
                    $subscriberName,
                    $queueName,
                    env('SUPERVISORD_COMMAND_PATH'),
                    $this->argument('processes'),
                    $this->argument('events'),
                ],
                $this->template()
            );

            file_put_contents($this->fileName($subscriberName), $fileContent);
        };
    }

    private function template(): string
    {
        return <<<EOF
[program:hoyvoy_{queue_name}]
process_name    = %(program_name)s_%(process_num)02d
command         = php {path}/artisan hoyvoy:domain-events:rabbitmq:consume {queue_name} {events_to_process}
autostart       = true
autorestart     = true
numprocs        = {processes}
user            = laradock
redirect_stderr = true
EOF;
    }

    private function fileName(string $queue): string
    {
        return sprintf('%s/%s.conf', strval(env('SUPERVISORD_CONF_PATH')), $queue);
    }
}
