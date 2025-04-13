<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Task;
use Carbon\Carbon;

class StartScheduledTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    

    public function handle()
    {
        \Log::info('Job is running...');
        \Log::info('NOW is: ' . now());

        $tasks = \App\Task::where('status', 'todo')
                        ->where('start_time', '<=', now())
                        ->get();

        \Log::info('Tasks found: ' . $tasks->count());

        foreach ($tasks as $task) {
            \Log::info("Trying to start task ID {$task->id}, title: {$task->title}");

            $updated = \DB::table('tasks')->where('id', $task->id)->update([
                'status' => 'in_progress',
                'updated_at' => now(),
            ]);

            \Log::info("Task ID {$task->id} update result: " . ($updated ? 'Success' : 'Failed'));
        }
    }


}
