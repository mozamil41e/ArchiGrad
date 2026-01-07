<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupervisorController;

use App\Livewire\Home\Categorys;
use App\Livewire\Home\HomePage;
use App\Livewire\Projects\Index;
use App\Livewire\Projects\Create;
use App\Livewire\Projects\Edit;
use App\Livewire\Projects\Show;


use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/h', [ReportController::class, 'generateHomePageReport'])->name('home.reports');
Route::get('/category', [ReportController::class, 'generateCategoryPageReport'])->name('category.reports');

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('supervisors', SupervisorController::class);
Route::apiResource('projects', ProjectController::class);




Route::get('/', HomePage::class)->name('home.page');
Route::get('/categorys', Categorys::class)->name('home.categorys');


Route::prefix('projects-live')->name('projects-live.')->group(function () {
    Route::get('/', Index::class)->name('index');
    Route::get('/create', Create::class)->name('create');
    Route::get('/{project}', Show::class)->name('show');
    Route::get('/{project}/edit', Edit::class)->name('edit');
});
