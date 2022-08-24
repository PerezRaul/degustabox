<?php

declare(strict_types=1);

namespace Src\TimeTracker\Application\CountByCriteria;

use Src\Shared\Application\CounterResponse;
use Src\Shared\Domain\Bus\Query\QueryHandler;
use Src\Shared\Domain\Criteria\Filters;

final class CountTimeTrackersByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(private TimeTrackersByCriteriaCounter $counter)
    {
    }

    public function __invoke(CountTimeTrackersByCriteriaQuery $query): CounterResponse
    {
        $filters = Filters::fromValues($query->filters());

        return new CounterResponse($this->counter->__invoke($filters));
    }
}
