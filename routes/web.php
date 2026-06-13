<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
// Route::post('/register', [AuthController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.export-pdf');

    Route::get('/department/print', [DepartmentController::class, 'print'])->name('department.print');
    Route::get('/department/export-csv', [DepartmentController::class, 'exportCsv'])->name('department.export-csv');
    Route::get('/department/export-excel', [DepartmentController::class, 'exportExcel'])->name('department.export-excel');
    Route::resource('departments', DepartmentController::class)->except(['create', 'edit', 'show']);

    Route::get('/course/print', [CourseController::class, 'print'])->name('course.print');
    Route::get('/course/export-csv', [CourseController::class, 'exportCsv'])->name('course.export-csv');
    Route::get('/course/export-excel', [CourseController::class, 'exportExcel'])->name('course.export-excel');
    Route::resource('courses', CourseController::class)->except(['create', 'edit', 'show']);

    Route::get('/student/print', [StudentController::class, 'print'])->name('student.print');
    Route::get('/student/export-csv', [StudentController::class, 'exportCsv'])->name('student.export-csv');
    Route::get('/student/export-excel', [StudentController::class, 'exportExcel'])->name('student.export-excel');
    Route::resource('students', StudentController::class)->except(['create', 'edit', 'show']);
});
