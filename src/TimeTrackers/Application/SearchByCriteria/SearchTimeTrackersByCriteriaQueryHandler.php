<?php

declare(strict_types=1);

namespace Src\TimeTracker\Application\SearchByCriteria;

use Src\TimeTracker\Application\TimeTrackerResponse;
use Src\TimeTracker\Application\TimeTrackersResponse;
use Src\TimeTracker\Domain\TimeTrackers;
use Src\TimeTracker\Domain\Services\TimeTrackersByCriteriaSearcher;
use Src\Shared\Domain\Bus\Query\QueryHandler;
use Src\Shared\Domain\Criteria\Filters;
use Src\Shared\Domain\Criteria\Orders;

use function Lambdish\Phunctional\map;

final class SearchTimeTrackersByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(private TimeTrackersByCriteriaSearcher $searcher)
    {
    }

    public function __invoke(SearchTimeTrackersByCriteriaQuery $query): TimeTrackersResponse
    {
        $filters = Filters::fromValues($query->filters());
        $orders  = Orders::fromValues($query->orders());

        $timeTrackers = $this->searcher->__invoke($filters, $orders, $query->limit(), $query->offset());

        return new TimeTrackersResponse(...map($this->toResponse(), $timeTrackers));
    }

    private function toResponse(): callable
    {
        return fn(TimeTrackers $timeTracker) => new TimeTrackerResponse(
            $timeTracker->id(),
            $timeTracker->name(),
            $timeTracker->startsAtTime(),
            $timeTracker->endsAtTime(),
            $timeTracker->createdAt(),
            $timeTracker->updatedAt(),
        );
    }
}
