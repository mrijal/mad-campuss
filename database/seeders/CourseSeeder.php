<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Department;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cs = Department::where('name', 'Computer Science')->first();
        $is = Department::where('name', 'Information Systems')->first();

        if ($cs) {
            Course::create(['department_id' => $cs->id, 'name' => 'Algorithm & Data Structures', 'sks' => 3]);
            Course::create(['department_id' => $cs->id, 'name' => 'Operating Systems', 'sks' => 3]);
        }

        if ($is) {
            Course::create(['department_id' => $is->id, 'name' => 'Database Management', 'sks' => 4]);
        }
    }
}
