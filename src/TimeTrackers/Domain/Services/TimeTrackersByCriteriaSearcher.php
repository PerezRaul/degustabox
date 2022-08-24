<?php

declare(strict_types=1);

namespace Src\TimeTracker\Domain\Services;

use Src\TimeTracker\Domain\TimeTrackerRepository;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\Filters;
use Src\Shared\Domain\Criteria\Groups;
use Src\Shared\Domain\Criteria\Orders;
use Src\TimeTracker\Domain\TimeTrackers;

final class TimeTrackersByCriteriaSearcher
{
    public function __construct(private TimeTrackerRepository $repository)
    {
    }

    public function __invoke(Filters $filters, Orders $orders, ?int $limit, ?int $offset): TimeTrackers
    {
        $criteria = new Criteria($filters, $orders, new Groups([]), $offset, $limit);

        return $this->repository->matching($criteria);
    }
}
