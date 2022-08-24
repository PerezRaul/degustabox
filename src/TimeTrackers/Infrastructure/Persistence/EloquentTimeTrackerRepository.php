<?php

declare(strict_types=1);

namespace Src\TimeTracker\Infrastructure\Persistence;

use Src\TimeTracker\Domain\TimeTrackers;
use Src\TimeTracker\Domain\TimeTrackerRepository;
use Src\TimeTracker\Domain\Customers;
use Src\TimeTracker\Infrastructure\Persistence\Eloquent\Customer as EloquentCustomer;
use Src\Shared\Domain\Customers\CustomerId;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentCriteriaConverter;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

use function Lambdish\Phunctional\map;

final class EloquentTimeTrackerRepository extends EloquentRepository implements TimeTrackerRepository
{
    public function save(TimeTrackers $customer): void
    {
        if (!$customer->hasChanges()) {
            return;
        }

        EloquentCustomer::updateOrCreate([
            'id' => $customer->id()->value(),
        ], $customer->toPrimitives());
    }

    public function search(CustomerId $id): ?TimeTrackers
    {
        $model = EloquentCustomer::find($id->value());

        if (null === $model) {
            return null;
        }

        return $this->transformModelToDomainEntity($model);
    }

    public function matching(Criteria $criteria): Customers
    {
        $query = EloquentCustomer::query();

        EloquentCriteriaConverter::apply($query, $criteria);

        return new Customers(map(function (EloquentCustomer $model) {
            return $this->transformModelToDomainEntity($model);
        }, $query->get()->all()));
    }

    public function matchingCount(Criteria $criteria): int
    {
        $query = EloquentCustomer::query();

        EloquentCriteriaConverter::apply($query, $criteria);

        return $query->count('id');
    }

    private function transformModelToDomainEntity(EloquentCustomer $model): TimeTrackers
    {
        return TimeTrackers::fromPrimitives((array) $model->getOriginal());
    }
}
