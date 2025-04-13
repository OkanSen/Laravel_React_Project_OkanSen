<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class InspectCachedTasks extends Command
{
    protected $signature = 'cache:inspect-tasks';
    protected $description = 'Display currently cached tasks.';

    public function handle()
    {
        $tasks = Cache::get('all_tasks');

        if (!$tasks) {
            $this->warn('No cached tasks found.');
            return;
        }

        $this->info("Found " . count($tasks) . " tasks in cache:");
        foreach ($tasks as $task) {
            $this->line("- [{$task->id}] {$task->title} ({$task->status})  @ {$task->updated_at}");
        }
    }
}

