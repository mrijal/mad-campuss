<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Computer Science', 'accreditation' => 'A'],
            ['name' => 'Information Systems', 'accreditation' => 'B'],
            ['name' => 'Software Engineering', 'accreditation' => 'A'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
