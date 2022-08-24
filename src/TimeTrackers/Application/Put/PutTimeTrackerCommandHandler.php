<?php

declare(strict_types=1);

namespace Src\TimeTracker\Application\Put;

use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTracker\Domain\TimeTrackerEndsAtTime;
use Src\TimeTracker\Domain\TimeTrackerName;

;

use Src\Shared\Domain\Bus\Command\CommandHandler;
use Src\TimeTracker\Domain\TimeTrackerStartsAtTime;

final class PutTimeTrackerCommandHandler implements CommandHandler
{
    public function __construct(private TimeTrackerPut $putter)
    {
    }

    public function __invoke(PutTimeTrackerCommand $command): void
    {
        $id           = new TimeTrackerId($command->id());
        $name         = new TimeTrackerName($command->name());
        $startsAtTime = new TimeTrackerStartsAtTime($command->startsAtTime());
        $endsAtTime   = new TimeTrackerEndsAtTime($command->endsAtTime());

        $this->putter->__invoke(
            $id,
            $name,
            $startsAtTime,
            $endsAtTime,
        );
    }
}
