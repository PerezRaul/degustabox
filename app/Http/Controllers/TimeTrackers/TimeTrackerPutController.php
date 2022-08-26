<?php

declare(strict_types=1);

namespace App\Http\Controllers\TimeTrackers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeTrackers\TimeTrackerPutRequest;
use Illuminate\Http\JsonResponse;
use Src\Shared\Domain\ArrUtils;
use Src\Shared\Domain\StrUtils;
use Src\TimeTrackers\Application\Put\PutTimeTrackerCommand;

final class TimeTrackerPutController extends Controller
{
    public function __invoke(TimeTrackerPutRequest $request, string $timeTrackerId): JsonResponse
    {
        $validated = ArrUtils::mapWithKeys(function ($value, $key) {
            return [StrUtils::camel($key) => $value];
        }, $request->validated());

        $this->dispatch(new PutTimeTrackerCommand($timeTrackerId, ...$validated));

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
