<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $studentsCount = Student::count();
        $departmentsCount = Department::count();
        $coursesCount = Course::count();

        // For donut chart logic or simple dashboard stats
        $departments = Department::withCount('students')->get();

        return view('dashboard', compact('studentsCount', 'departmentsCount', 'coursesCount', 'departments'));
    }
}
