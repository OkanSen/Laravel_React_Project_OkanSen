<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\StartScheduledTasks;

class DispatchScheduledTasks extends Command
{
    protected $signature = 'tasks:dispatch';
    protected $description = 'Dispatch the StartScheduledTasks job';

    public function handle()
    {
        $this->info('Dispatching job...');
        dispatch(new StartScheduledTasks());
        $this->info('Dispatched ✅');
    }
}
