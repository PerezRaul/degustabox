<?php

declare(strict_types=1);

namespace Hoyvoy\Backoffice\Audits\Application\Listeners;

use Hoyvoy\Backoffice\Audits\Application\Create\CreateAuditCommand;
use Hoyvoy\Shared\Domain\Audits\Events\Auditable;
use Hoyvoy\Shared\Domain\Bus\Command\CommandBus;
use Hoyvoy\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Hoyvoy\Shared\Domain\FileUtils;
use Hoyvoy\Shared\Domain\ValueObject\Uuid;

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
