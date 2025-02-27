<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::table('projects')->updateOrInsert([
            'id' => 1
        ], [
            'id' => 1,
            'name' => 'Project 1',
            'description' => 'This is project 1',
            'status' => Project::STATUS_PLANNING,
            'start_date' => Carbon::now(),
        ]);

        Project::table('projects')->updateOrInsert([
            'id' => 2
        ], [
            'id' => 2,
            'name' => 'Project 2',
            'description' => 'This is project 2',
            'status' => Project::STATUS_PLANNING,
            'start_date' => Carbon::now(),
        ]);

    }
}
