<?php

declare(strict_types=1);

namespace Src\TimeTracker\Application\Put;

use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\TimeTracker\Domain\TimeTrackerCreatedAt;
use Src\TimeTracker\Domain\TimeTrackers;
use Src\TimeTracker\Domain\TimeTrackerEndsAtTime;
use Src\TimeTracker\Domain\TimeTrackerName;
use Src\TimeTracker\Domain\TimeTrackerRepository;
use Src\TimeTracker\Domain\TimeTrackerStartsAtTime;
use Src\TimeTracker\Domain\TimeTrackerUpdatedAt;
use Src\Shared\Domain\Bus\Event\EventBus;
use Src\Shared\Domain\Bus\Query\QueryBus;

final class TimeTrackerPut
{
    public function __construct(
        private TimeTrackerRepository $repository,
        private EventBus $eventBus,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(
        TimeTrackerId $id,
        TimeTrackerName $name,
        TimeTrackerStartsAtTime $startsAtTime,
        TimeTrackerEndsAtTime $endsAtTime,
    ): void {
        $timeTracker = $this->repository->search($id);

        $timeTracker = null === $timeTracker ?
            $this->create(
                $id,
                $name,
                $startsAtTime,
                $endsAtTime,
            ) :
            $this->update(
                $timeTracker,
                $name,
                $startsAtTime,
                $endsAtTime,
            );

        $this->repository->save($timeTracker);
        $this->eventBus->publish(...$timeTracker->pullDomainEvents());
    }

    private function create(
        TimeTrackerId $id,
        TimeTrackerName $name,
        TimeTrackerStartsAtTime $startsAtTime,
        TimeTrackerEndsAtTime $endsAtTime,
    ): TimeTrackers {
        return TimeTrackers::create(
            $id,
            $name,
            $startsAtTime,
            $endsAtTime,
            TimeTrackerCreatedAt::now(),
            TimeTrackerUpdatedAt::now(),
        );
    }

    private function update(
        TimeTrackers $timeTracker,
        TimeTrackerName $name,
        TimeTrackerStartsAtTime $startsAtTime,
        TimeTrackerEndsAtTime $endsAtTime,
    ): TimeTrackers {
        $timeTracker->update(
            $name,
            $startsAtTime,
            $endsAtTime,
            TimeTrackerUpdatedAt::now(),
        );

        return $timeTracker;
    }
}
