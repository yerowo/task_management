<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the task data
        $tasks = [
            [
                'task_name' => 'Task 1',
                'priority' => 0, // High
                'status' => 1,   // Active
            ],
            [
                'task_name' => 'Task 2',
                'priority' => 1, // Medium
                'status' => 1,   // Active
            ],
            [
                'task_name' => 'Task 3',
                'priority' => 2, // Low
                'status' => 1,   // Active
            ],
            // Add more task data as needed
        ];

        // Insert the task data into the tasks table
        DB::table('tasks')->insert($tasks);
    }
}
