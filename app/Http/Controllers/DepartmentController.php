<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $departments = Department::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('accreditation', 'like', "%{$search}%");
        })->paginate(10);

        return view('departments.index', compact('departments', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'accreditation' => 'required|string|max:5',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'accreditation' => 'required|string|max:5',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    public function print()
    {
        $departments = Department::withCount('students')->get();
        return view('departments.print', compact('departments'));
    }

    public function exportCsv()
    {
        $fileName = 'departments.csv';

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
                "Accreditation",
                "Students Count"
            ], ';');

            $departments = Department::withCount('students')->get();

            foreach ($departments as $dept) {
                fputcsv($file, [
                    $dept->id,
                    $dept->name,
                    $dept->accreditation,
                    $dept->students_count
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel()
    {
        $departments = Department::withCount('students')->get();
        return response()
                ->view('departments.excel', compact('departments'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename=departments.xls');
    }
}
