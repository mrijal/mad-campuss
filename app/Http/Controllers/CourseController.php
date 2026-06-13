<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $departmentId = $request->input('department_id');

        $courses = Course::with('department')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($departmentId, function ($query, $departmentId) {
                return $query->where('department_id', $departmentId);
            })
            ->paginate(10);

        $departments = Department::all();

        return view('courses.index', compact('courses', 'departments', 'search', 'departmentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function print()
    {
        $courses = Course::with('department')->get();
        return view('courses.print', compact('courses'));
    }

    public function exportCsv()
    {
        $fileName = 'courses.csv';

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                "ID",
                "Name",
                "Department",
                "SKS"
            ], ';');

            $courses = Course::with('department')->get();

            foreach ($courses as $course) {
                fputcsv($file, [
                    $course->id,
                    $course->name,
                    $course->department->name ?? "-",
                    $course->sks
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel()
    {
        $courses = Course::with('department')->get();
        return response()
                ->view('courses.excel', compact('courses'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename=courses.xls');
    }
}
