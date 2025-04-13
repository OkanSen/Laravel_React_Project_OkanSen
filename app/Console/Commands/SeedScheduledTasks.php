<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use Carbon\Carbon;

class SeedScheduledTasks extends Command
{
    protected $signature = 'tasks:seed {--count=5}';
    protected $description = 'Create dummy scheduled tasks for testing';

    public function handle()
    {
        $count = $this->option('count');

        for ($i = 1; $i <= $count; $i++) {
            $task = Task::create([
                'title' => "Task $i",
                'description' => "Auto-generated task $i",
                'status' => 'todo',
                'start_time' => Carbon::now()->subMinutes(rand(1, 10)), // already due 5 random deadlines
            ]);
            $this->info("Created: {$task->title}");
        }

        $this->info("$count tasks seeded!");
    }
}
