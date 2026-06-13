<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $departmentId = $request->input('department_id');

        $students = Student::with('department')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('nim', 'like', "%{$search}%");
            })
            ->when($departmentId, function ($query, $departmentId) {
                return $query->where('department_id', $departmentId);
            })
            ->paginate(10);

        $departments = Department::all();

        return view('students.index', compact('students', 'departments', 'search', 'departmentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'nim' => 'required|string|max:20|unique:students,nim',
            'name' => 'required|string|max:255',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'nim' => 'required|string|max:20|unique:students,nim,' . $student->id,
            'name' => 'required|string|max:255',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function exportCsv() {
        $fileName = 'student.csv';

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"' ,
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                "ID",
                "NIM",
                "Name",
                "Department"
            ], ';');

            $students = Student::with('department')->get();

            foreach ($students as $key => $student) {
                fputcsv($file, [
                    $student->id,
                    $student->nim,
                    $student->name,
                    $student->department->name ?? "-"
                ]);
            }

            fclose($file);
        };
        // dd("Test");
        
        return response()->stream($callback, 200, $headers);
    }

    public function print() {
        $students = Student::with('department')->get();

        return view('students.print', compact('students'));
    }

    public function exportExcel()
    {
        $students = Student::with('department')->get();
        return response()
                ->view('students.excel', compact('students'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename=student.xls');
    }
}
