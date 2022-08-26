<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Infrastructure\Persistence;

use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\TimeTrackers\TimeTrackerId;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentCriteriaConverter;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;
use Src\TimeTrackers\Domain\TimeTracker;
use Src\TimeTrackers\Domain\TimeTrackerRepository;
use Src\TimeTrackers\Domain\TimeTrackers;
use Src\TimeTrackers\Infrastructure\Persistence\Eloquent\TimeTracker as EloquentTimeTracker;

use function Lambdish\Phunctional\map;

final class EloquentTimeTrackerRepository extends EloquentRepository implements TimeTrackerRepository
{
    public function save(TimeTracker $timeTracker): void
    {
        if (!$timeTracker->hasChanges()) {
            return;
        }

        EloquentTimeTracker::updateOrCreate([
            'id' => $timeTracker->id()->value(),
        ], $timeTracker->toPrimitives());
    }

    public function search(TimeTrackerId $id): ?TimeTracker
    {
        $model = EloquentTimeTracker::find($id->value());

        if (null === $model) {
            return null;
        }

        return $this->transformModelToDomainEntity($model);
    }

    public function matching(Criteria $criteria): TimeTrackers
    {
        $query = EloquentTimeTracker::query();

        EloquentCriteriaConverter::apply($query, $criteria);

        return new TimeTrackers(map(function (EloquentTimeTracker $model) {
            return $this->transformModelToDomainEntity($model);
        }, $query->get()->all()));
    }

    public function matchingCount(Criteria $criteria): int
    {
        $query = EloquentTimeTracker::query();

        EloquentCriteriaConverter::apply($query, $criteria);

        return $query->count('id');
    }

    private function transformModelToDomainEntity(EloquentTimeTracker $model): TimeTracker
    {
        return TimeTracker::fromPrimitives((array) $model->getOriginal());
    }
}
