<?php

declare(strict_types=1);

namespace Hoyvoy\Backoffice\Audits\Application\Create;

//use Hoyvoy\Shared\Domain\Http\HttpClient;
use Src\Shared\Domain\Bus\Command\CommandHandler;
use Src\Shared\Domain\Config\Config;

final class CreateAuditCommandHandler implements CommandHandler
{
    public function __construct(private Config $config)
    {
    }

    public function __invoke(CreateAuditCommand $command): void
    {
        if (true !== $this->config->get('backoffice.audit.generate_audits')) {
            return;
        }

        /*$this->httpClient->service('ms-shared')->post(sprintf('audits/%s', $command->id()), [
            'aggregate_id' => $command->aggregateId(),
            'event_name'   => $command->eventName(),
            'occurred_at'  => $command->occurredAt(),
            'body'         => $command->body(),
        ]);*/
    }
}
