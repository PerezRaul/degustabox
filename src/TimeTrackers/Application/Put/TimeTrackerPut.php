<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Application\Put;

use Src\Shared\Domain\Bus\Query\QueryBus;
use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTrackers\Domain\TimeTracker;
use Src\TimeTrackers\Domain\TimeTrackerCreatedAt;
use Src\TimeTrackers\Domain\TimeTrackerDate;
use Src\TimeTrackers\Domain\TimeTrackerEndsAtTime;
use Src\TimeTrackers\Domain\TimeTrackerName;
use Src\TimeTrackers\Domain\TimeTrackerRepository;
use Src\TimeTrackers\Domain\TimeTrackerStartsAtTime;
use Src\TimeTrackers\Domain\TimeTrackerUpdatedAt;
use Src\Shared\Domain\Bus\Event\EventBus;

final class TimeTrackerPut
{
    public function __construct(
        private TimeTrackerRepository $repository,
        private EventBus $eventBus
    ) {
    }

    public function __invoke(
        TimeTrackerId $id,
        TimeTrackerName $name,
        TimeTrackerDate $date,
        TimeTrackerStartsAtTime $startsAtTime,
        TimeTrackerEndsAtTime $endsAtTime,
    ): void {
        $timeTracker = $this->repository->search($id);

        $timeTracker = null === $timeTracker ?
            $this->create(
                $id,
                $name,
                $date,
                $startsAtTime,
                $endsAtTime,
            ) :
            $this->update(
                $timeTracker,
                $name,
                $date,
                $startsAtTime,
                $endsAtTime,
            );

        $this->repository->save($timeTracker);
        $this->eventBus->publish(...$timeTracker->pullDomainEvents());
    }

    private function create(
        TimeTrackerId $id,
        TimeTrackerName $name,
        TimeTrackerDate $date,
        TimeTrackerStartsAtTime $startsAtTime,
        TimeTrackerEndsAtTime $endsAtTime,
    ): TimeTracker {
        return TimeTracker::create(
            $id,
            $name,
            $date,
            $startsAtTime,
            $endsAtTime,
            TimeTrackerCreatedAt::now(),
            TimeTrackerUpdatedAt::now(),
        );
    }

    private function update(
        TimeTracker $timeTracker,
        TimeTrackerName $name,
        TimeTrackerDate $date,
        TimeTrackerStartsAtTime $startsAtTime,
        TimeTrackerEndsAtTime $endsAtTime,
    ): TimeTracker {
        $timeTracker->update(
            $name,
            $date,
            $startsAtTime,
            $endsAtTime,
            TimeTrackerUpdatedAt::now(),
        );

        return $timeTracker;
    }
}
