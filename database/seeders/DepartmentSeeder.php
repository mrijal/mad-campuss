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
            ['name' => 'Teknik Informatika', 'accreditation' => 'A'],
            ['name' => 'Bisnis Digital', 'accreditation' => 'A'],
            ['name' => 'Desain Komunikasi Visual', 'accreditation' => 'A'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
