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

    Route::resource('departments', DepartmentController::class)->except(['create', 'edit', 'show']);
    Route::resource('courses', CourseController::class)->except(['create', 'edit', 'show']);
    Route::resource('students', StudentController::class)->except(['create', 'edit', 'show']);
});
