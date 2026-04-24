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
        $tif = Department::where('name', 'Teknik Informatika')->first();
        $bd = Department::where('name', 'Bisnis Digital')->first();
        $dkv = Department::where('name', 'Desain Komunikasi Visual')->first();

        if ($tif) {
            Course::create(['department_id' => $tif->id, 'name' => 'Web Programming', 'sks' => 3]);
            Course::create(['department_id' => $tif->id, 'name' => 'Mobile Programming', 'sks' => 3]);
        }

        if ($bd) {
            Course::create(['department_id' => $bd->id, 'name' => 'Ilmu Data dan Analisa Bisnis', 'sks' => 3]);
        }

        if ($dkv) {
            Course::create(['department_id' => $dkv->id, 'name' => 'Desain Website', 'sks' => 3]);
        }
    }
}
