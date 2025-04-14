<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use App\Jobs\StartTaskNow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DispatchSmartTasks extends Command
{
    protected $signature = 'job:dispatch-smart';
    protected $description = 'Smartly dispatch tasks for execution based on current status and start_time';

    public function handle()
    {
        $now = now();
        $dispatchedCount = 0;

        // Only process tasks that can still progress
        $validStatuses = ['Pending', 'In Progress', 'Needs Revision'];

        $tasks = Task::whereIn('status', $validStatuses)
            ->whereNotNull('start_time')
            ->get();

        foreach ($tasks as $task) {
            $startTime = Carbon::parse($task->start_time);
            $delay = $now->diffInSeconds($startTime, false); // negative if time has passed

            if ($delay <= 0) {
                dispatch(new StartTaskNow($task));
                Log::info("🚀 Dispatched task '{$task->title}' immediately (ID {$task->id})");
                $this->info("✔️ Dispatched '{$task->title}' immediately");
            } else {
                dispatch((new StartTaskNow($task))->delay($delay));
                Log::info("🕒 Scheduled task '{$task->title}' to run in {$delay}s (ID {$task->id})");
                $this->info("⏳ Scheduled '{$task->title}' in {$delay} seconds");
            }

            $dispatchedCount++;
        }

        if ($dispatchedCount === 0) {
            $this->warn("No eligible tasks found to dispatch.");
            Log::info("🛑 No eligible tasks to dispatch at {$now}");
        } else {
            $this->line("✅ Total dispatched: {$dispatchedCount}");
        }
    }
}
