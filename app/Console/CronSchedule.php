<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

class CronSchedule {
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function __invoke(Schedule $schedule): void {
        /** telescope */
        $schedule->command('telescope:prune --hours=48')->daily();
        // $schedule->command(PruneStaleTagsCommand::class)->hourly();
    }
}
