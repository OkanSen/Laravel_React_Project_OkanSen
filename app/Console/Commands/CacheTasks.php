<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Task;

class CacheTasks extends Command
{
    protected $signature = 'cache:tasks';
    protected $description = 'Cache all tasks for 300 seconds';

    public function handle()
    {
        Cache::forget('all_tasks');
        
        $this->info('Caching tasks manually...');
        $tasks = Task::with('user')->get();

        Cache::put('all_tasks', $tasks, 300); // 5 mins

        \Log::info('Tasks cached successfully', ['count' => $tasks->count()]);
        \Log::info('Cached tasks:', $tasks->toArray());

        $this->info("Cached {$tasks->count()} tasks for 300 seconds.");
    }
}
