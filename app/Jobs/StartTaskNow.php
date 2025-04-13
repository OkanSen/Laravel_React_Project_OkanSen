<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Notifications\TaskStatusChanged;

class StartTaskNow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        Log::info("Handling task '{$this->task->title}' (ID: {$this->task->id})");

        $this->task->status = 'in_progress';
        $this->task->save();

        $user = $this->task->user; // assumes Task has `user()` relation

        if ($user) {
            $user->notify(new TaskStatusChanged($this->task));
            Log::info("Notification sent to user ID {$user->id} ({$user->email}) for task '{$this->task->title}'");
        } else {
            Log::warning("No user found for task '{$this->task->title}' (ID: {$this->task->id})");
        }

        Log::info("Task '{$this->task->title}' updated to 'in_progress'");
    }
}
