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
            Student::create([
                'department_id' => $cs->id,
                'nim' => '23552011138',
                'name' => 'Muhammad Rijal'
            ]);
        }

        if ($is) {
            Student::create([
                'department_id' => $is->id,
                'nim' => '24552011138',
                'name' => 'Bunga Lestari'
            ]);
        }

        if ($dkv) {
            Student::create([
                'department_id' => $dkv->id,
                'nim' => '25550122129',
                'name' => 'Budi Oetomo'
            ]);
        }
    }
}
