<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Shared\Domain\Bus\Command\CommandBus;
use Src\TimeTrackers\Application\Put\PutTimeTrackerCommand;

class TimeTrackerSeeder extends Seeder
{
    public function run(): void
    {
        $timeTrackers = require __DIR__ . '/time_trackers/time_trackers.php';

        foreach ($timeTrackers as $timeTracker) {
            app(CommandBus::class)->dispatch(new PutTimeTrackerCommand(
                $timeTracker['id'],
                $timeTracker['name'],
                $timeTracker['date'],
                $timeTracker['starts_at_time'],
                $timeTracker['ends_at_time'],
            ));
        }
    }
}
