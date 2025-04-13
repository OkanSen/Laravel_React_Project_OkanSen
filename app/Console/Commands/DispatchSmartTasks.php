<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use App\Jobs\StartTaskNow;
use Carbon\Carbon;

class DispatchSmartTasks extends Command
{
    protected $signature = 'job:dispatch-smart';
    protected $description = 'Dispatch all TODO tasks with appropriate delay';

    public function handle()
    {
        $tasks = Task::where('status', 'todo')->get();
        $dispatchedCount = 0;

        foreach ($tasks as $task) {
            $delay = now()->diffInSeconds(Carbon::parse($task->start_time), false);

            if ($delay <= 0) {
                dispatch(new StartTaskNow($task));
                \Log::info("Dispatched task '{$task->title}' immediately (ID {$task->id})");
                $this->info("Dispatched '{$task->title}' immediately");
            } else {
                dispatch((new StartTaskNow($task))->delay($delay));
                \Log::info("Scheduled task '{$task->title}' in {$delay}s (ID {$task->id})");
                $this->info("Scheduled '{$task->title}' in {$delay} seconds");
            }

            $dispatchedCount++;
        }

        $this->line("Total dispatched: {$dispatchedCount}");
    }
}
