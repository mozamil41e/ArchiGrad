<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('supervisors', SupervisorController::class);
Route::apiResource('projects', ProjectController::class);
