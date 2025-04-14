<?php

// database/seeders/StatusesSeeder.php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StatusesSeeder extends Seeder
{
    public function run()
    {
        // Inserting default statuses
        DB::table('statuses')->insert([
            ['name' => 'Pending', 'order' => 1],
            ['name' => 'In Progress', 'order' => 2],
            ['name' => 'Needs Revision', 'order' => 3],
            ['name' => 'Completed', 'order' => 4],
        ]);
    }
}
