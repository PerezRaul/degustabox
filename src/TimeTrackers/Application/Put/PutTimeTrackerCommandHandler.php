<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Application\Put;

use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTrackers\Domain\TimeTrackerDate;
use Src\TimeTrackers\Domain\TimeTrackerEndsAtTime;
use Src\TimeTrackers\Domain\TimeTrackerName;
use Src\Shared\Domain\Bus\Command\CommandHandler;
use Src\TimeTrackers\Domain\TimeTrackerStartsAtTime;

final class PutTimeTrackerCommandHandler implements CommandHandler
{
    public function __construct(private TimeTrackerPut $putter)
    {
    }

    public function __invoke(PutTimeTrackerCommand $command): void
    {
        $id           = new TimeTrackerId($command->id());
        $name         = new TimeTrackerName($command->name());
        $date         = new TimeTrackerDate($command->date());
        $startsAtTime = new TimeTrackerStartsAtTime($command->startsAtTime());
        $endsAtTime   = new TimeTrackerEndsAtTime($command->endsAtTime());

        $this->putter->__invoke(
            $id,
            $name,
            $date,
            $startsAtTime,
            $endsAtTime,
        );
    }
}
