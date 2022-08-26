<?php

declare(strict_types=1);

namespace App\Http\Controllers\TimeTrackers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeTrackers\TimeTrackersGetRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;
use Src\Shared\Application\CounterResponse;
use Src\Shared\Domain\ArrUtils;
use Src\Shared\Domain\DateUtils;
use Src\TimeTrackers\Application\CountByCriteria\CountTimeTrackersByCriteriaQuery;
use Src\TimeTrackers\Application\SearchByCriteria\SearchTimeTrackersByCriteriaQuery;
use Src\TimeTrackers\Application\TimeTrackerResponse;
use Src\TimeTrackers\Application\TimeTrackersResponse;
use Src\TimeTrackers\Domain\Filters\TimeTrackerFilterParserFactory;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\each;

final class TimeTrackersGetController extends Controller
{
    public function __invoke(TimeTrackersGetRequest $request): View
    {
        $filters = TimeTrackerFilterParserFactory::get(array_merge(
            ArrUtils::except($request->validated(), 'page', 'per_page'),
            ['date' => Date::now()->format('Y-m-d')]
        ));

        /** @var CounterResponse $numberTimeTrackers */
        $numberTimeTrackers = $this->ask(new CountTimeTrackersByCriteriaQuery($filters));

        if ($numberTimeTrackers->total() === 0) {
            $timeTracker = ['data' => []];

            return view("home", compact('timeTracker'));
        }

        /** @var TimeTrackersResponse $timeTrackers */
        $timeTrackers = $this->ask(new SearchTimeTrackersByCriteriaQuery(
            $filters,
            [['name', 'asc']],
            100,
            null
        ));

        $timeTrackers = ArrUtils::groupBy(
            $timeTrackers->timeTrackers(),
            fn(TimeTrackerResponse $timeTracker) => $timeTracker->name()
        );

        $timeTrackers = map(function (array $timeTrackers) {
            $seconds = 0;
            $date    = '';
            each(function (TimeTrackerResponse $timeTracker) use (&$date, &$seconds) {
                $date    = DateUtils::stringToDate($timeTracker->date())->getTimestamp();
                $seconds += (null === $timeTracker->endsAtTime()) ? DateUtils::stringToDate(date('H:i:s'))->getTimestamp() : DateUtils::stringToDate($timeTracker->endsAtTime())->getTimestamp() - DateUtils::stringToDate($timeTracker->startsAtTime())->getTimestamp();
            }, $timeTrackers);

            return [
                'date'       => gmdate('d-m-Y', ($date)),
                'time_spent' => gmdate('H:i:s', $seconds),
            ];
        }, $timeTrackers);

        $timeTracker = [
            'data' => map(
                $this->timeTrackerResponse(),
                $timeTrackers
            )
        ];

        return view("home", compact('timeTracker'));
    }

    private function timeTrackerResponse(): callable
    {
        return fn(array $dateTime, string $name) => [
            'name'      => $name,
            'timestamp' => $dateTime,
        ];
    }
}
