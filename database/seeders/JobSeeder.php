<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create([
            'title' => 'Frontend Developer',
            'department_id' => 1,
        ]);

        Job::create([
            'title' => 'Backend Developer',
            'department_id' => 1,
        ]);

        Job::create([
            'title' => 'Recruiter',
            'department_id' => 2,
        ]);

        Job::create([
            'title' => 'Project Manager',
            'department_id' => 3,
        ]);

        Job::create([
            'title' => 'Scrum Master',
            'department_id' => 3,
        ]);
    }
}
