<?php

declare(strict_types=1);

namespace Src\TimeTrackers\Application\SearchByCriteria;

use Src\TimeTrackers\Application\TimeTrackerResponse;
use Src\TimeTrackers\Application\TimeTrackersResponse;
use Src\TimeTrackers\Domain\TimeTracker;
use Src\TimeTrackers\Domain\Services\TimeTrackersByCriteriaSearcher;
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
        return fn(TimeTracker $timeTracker) => new TimeTrackerResponse(
            $timeTracker->id(),
            $timeTracker->name(),
            $timeTracker->date(),
            $timeTracker->startsAtTime(),
            $timeTracker->endsAtTime(),
            $timeTracker->createdAt(),
            $timeTracker->updatedAt(),
        );
    }
}
