<?php

namespace App\Console;

use Illuminate\Cache\Console\PruneStaleTagsCommand;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleHandler
{
    public function __invoke(Schedule $schedule): void
    {
        $schedule->command(PruneStaleTagsCommand::class)->hourly();
        $schedule->command('telescope:prune --hours=48')->daily();

        // ...
    }
}
