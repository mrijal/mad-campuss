<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\DepartmentApiController;

Route::apiResource('student', StudentApiController::class);
Route::apiResource('department', DepartmentApiController::class);