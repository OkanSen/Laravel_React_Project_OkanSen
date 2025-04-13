<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\StartScheduledTasks;
use Illuminate\Support\Carbon;

class DispatchDelayedTaskCommand extends Command
{
    protected $signature = 'job:dispatch-delayed {delayInSeconds=10}';
    protected $description = 'Dispatch StartScheduledTasks job with a delay';

    public function handle()
    {
        $delay = (int) $this->argument('delayInSeconds');

        $this->info("Dispatching job with {$delay} second(s) delay...");

        StartScheduledTasks::dispatch()->delay(now()->addSeconds($delay));

        $this->info("Job dispatched!");
    }
}
