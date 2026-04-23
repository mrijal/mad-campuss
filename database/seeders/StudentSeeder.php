<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Department;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cs = Department::where('name', 'Computer Science')->first();
        $is = Department::where('name', 'Information Systems')->first();

        if ($cs) {
            for ($i = 1; $i <= 10; $i++) {
                Student::create([
                    'department_id' => $cs->id,
                    'nim' => 'CS100' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'name' => 'CS Student ' . $i
                ]);
            }
        }

        if ($is) {
            for ($i = 1; $i <= 5; $i++) {
                Student::create([
                    'department_id' => $is->id,
                    'nim' => 'IS100' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'name' => 'IS Student ' . $i
                ]);
            }
        }
    }
}
