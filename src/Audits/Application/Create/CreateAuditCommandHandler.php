<?php

declare(strict_types=1);

namespace Src\Audits\Application\Create;

use Src\Shared\Domain\Bus\Command\CommandHandler;

final class CreateAuditCommandHandler implements CommandHandler
{
    public function __construct()
    {
    }

    public function __invoke(): void
    {
    }
}
