<?php

// app/Console/Commands/ClearTaskCache.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearTaskCache extends Command
{
    protected $signature = 'cache:clear-tasks';
    protected $description = 'Clear the cached tasks list';

    public function handle()
    {
        if (Cache::has('all_tasks')) {
            Cache::forget('all_tasks');
            $this->info('✅ Cache key "all_tasks" found and cleared.');
            \Log::info('Cleared "all_tasks" from cache.');
        } else {
            $this->warn('⚠️ Cache key "all_tasks" not found or expired.');
            \Log::warning('Failed to find "all_tasks" in cache for clearing.');
        }
    }
}
