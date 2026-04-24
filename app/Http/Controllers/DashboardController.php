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

        // Data for charts
        $departments = Department::withCount(['students', 'courses'])->get();
        $accreditations = Department::select('accreditation', \DB::raw('count(*) as total'))
                                    ->groupBy('accreditation')
                                    ->get();

        return view('dashboard', compact('studentsCount', 'departmentsCount', 'coursesCount', 'departments', 'accreditations'));
    }

    public function exportPdf()
    {
        $studentsCount = Student::count();
        $departmentsCount = Department::count();
        $coursesCount = Course::count();

        $departments = Department::withCount(['students', 'courses'])->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.report', compact(
            'studentsCount', 'departmentsCount', 'coursesCount', 'departments'
        ));

        return $pdf->download('Dashboard_Report.pdf');
    }
}
