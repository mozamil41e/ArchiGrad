<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/', [ReportController::class, 'generateHomePageReport'])->name('home.reports');
Route::get('/category', [ReportController::class, 'generateCategoryPageReport'])->name('category.reports');

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('supervisors', SupervisorController::class);
Route::apiResource('projects', ProjectController::class);
