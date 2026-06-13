<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function index() { 
        $students = Student::with('department')->get();
    
        if (!$students) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Student data not found"
            ], 404);
        }

        return response()->json([
            'status' => 202,
            'success' => true,
            'message' => 'Student data successfully fetched',
            'data' => $students
        ], 200);
    }

    public function show($id) {
        $student = Student::with('department')->find($id);
    
        if (!$student) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Student data not found"
            ], 404);
        }

        return response()->json([
            'status' => 202,
            'success' => true,
            'message' => 'Student data successfully fetched',
            'data' => $student
        ], 200);
    }

    public function store(Request $request) {
        $student = Student::create($request->all());

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Student Data Created',
            'data' => $student
        ], 201);
    }

    public function update(Request $request, $id) {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Student data not found"
            ], 404);
        }

        $student->update($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Student Data Updated',
            'data' => $student
        ], 200);
    }

    public function destroy($id) {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Student data not found"
            ], 404);
        }

        $student->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Student Data Deleted',
        ], 200);
    }
}
