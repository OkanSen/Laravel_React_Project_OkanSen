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

    protected $statusFlow = [
        'Pending' => 'In Progress',
        'In Progress' => 'Needs Revision',
        'Needs Revision' => 'Completed',
        'Completed' => null, // Final state
    ];

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        $currentStatus = $this->task->status;
        $nextStatus = $this->statusFlow[$currentStatus] ?? null;

        Log::info("⏳ Handling task '{$this->task->title}' (ID: {$this->task->id}) | Current status: {$currentStatus}");

        if (!$nextStatus) {
            Log::info("✅ Task '{$this->task->title}' (ID: {$this->task->id}) is already in its final state: '{$currentStatus}'");
            return;
        }

        $this->task->status = $nextStatus;
        $this->task->save();

        Log::info("🔁 Task '{$this->task->title}' status updated: '{$currentStatus}' → '{$nextStatus}'");

        $user = $this->task->user;

        if ($user) {
            $user->notify(new TaskStatusChanged($this->task));
            Log::info("📩 Notification sent to user ID {$user->id} ({$user->email})");
        } else {
            Log::warning("⚠️ No user found for task '{$this->task->title}' (ID: {$this->task->id})");
        }
    }
}
