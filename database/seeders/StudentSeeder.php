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
        $cs = Department::where('name', 'Teknik Informatika')->first();
        $is = Department::where('name', 'Bisnis Digital')->first();
        $dkv = Department::where('name', 'Desain Komunikasi Visual')->first();

        if ($cs) {
            for ($i = 1; $i <= 10; $i++) {
                Student::create([
                    'department_id' => $cs->id,
                    'nim' => '23552011138',
                    'name' => 'Muhammad Rijal'
                ]);
            }
        }

        if ($is) {
            for ($i = 1; $i <= 5; $i++) {
                Student::create([
                    'department_id' => $is->id,
                    'nim' => '24552011138',
                    'name' => 'Bunga Lestari'
                ]);
            }
        }

        if ($dkv) {
            for ($i = 1; $i <= 10; $i++) {
                Student::create([
                    'department_id' => $dkv->id,
                    'nim' => '25550122129',
                    'name' => 'Budi Oetomo'
                ]);
            }
        }
    }
}
