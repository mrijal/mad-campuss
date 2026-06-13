<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentApiController extends Controller
{
    public function index() { 
        $departments = Department::with('courses', 'students')->get();
    
        if (!$departments) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Department data not found"
            ], 404);
        }

        return response()->json([
            'status' => 202,
            'success' => true,
            'message' => 'Department data successfully fetched',
            'data' => $departments
        ], 200);
    }

    public function show($id) {
        $department = Department::with('courses', 'students')->find($id);
    
        if (!$department) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Department data not found"
            ], 404);
        }

        return response()->json([
            'status' => 202,
            'success' => true,
            'message' => 'Department data successfully fetched',
            'data' => $department
        ], 200);
    }

    public function store(Request $request) {
        $department = Department::create($request->all());

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Department Data Created',
            'data' => $department
        ], 201);
    }

    public function update(Request $request, $id) {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Department data not found"
            ], 404);
        }

        $department->update($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Department Data Updated',
            'data' => $department
        ], 200);
    }

    public function destroy($id) {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => "Department data not found"
            ], 404);
        }

        $department->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Department Data Deleted',
        ], 200);
    }
}
