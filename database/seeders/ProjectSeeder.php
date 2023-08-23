<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the project data
        $projects = [
            [
                'name' => 'Production',
            ],
            [
                'name' => 'IT Projects',
            ],
            [
                'name' => 'Business',
            ],
            [
                'name' => 'Communication',
            ],
            // Add more project data as needed
        ];

        // Insert the project data into the projects table
        DB::table('projects')->insert($projects);
    }
}
