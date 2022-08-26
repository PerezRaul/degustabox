<?php

declare(strict_types=1);

namespace Src\Audits\Application\Listeners;

use Src\Audits\Application\Create\CreateAuditCommand;
use Src\Shared\Domain\Audits\Events\Auditable;
use Src\Shared\Domain\Bus\Command\CommandBus;
use Src\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Src\Shared\Domain\FileUtils;
use Src\Shared\Domain\ValueObject\Uuid;

final class CreateOnAuditableEventOccurred implements DomainEventSubscriber
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public static function subscribedTo(): array
    {
        return FileUtils::classesThatImplements(Auditable::class);
    }

    public function __invoke(Auditable $event): void
    {
        $this->commandBus->dispatch(new CreateAuditCommand(
            Uuid::random()->value(),
            $event->aggregateId(),
            $event::eventName(),
            $event->occurredAt(),
            $event->toPrimitives(),
        ));
    }
}
