<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupervisorController;

use App\Livewire\Home\Categorys;
use App\Livewire\Home\HomePage;


use App\Livewire\Projects\Index as ProjectsIndex;
use App\Livewire\Projects\Create as ProjectsCreate;
use App\Livewire\Projects\Edit as ProjectsEdit;
use App\Livewire\Projects\Show as ProjectsShow;

use App\Livewire\Departments\Index as DepartmentsIndex;
use App\Livewire\Departments\Create as DepartmentsCreate;
use App\Livewire\Departments\Edit as DepartmentsEdit;
use App\Livewire\Departments\Show as DepartmentsShow;

use App\Livewire\Supervisors\Index as SupervisorsIndex;
use App\Livewire\Supervisors\Create as SupervisorsCreate;
use App\Livewire\Supervisors\Edit as SupervisorsEdit;
use App\Livewire\Supervisors\Show as SupervisorsShow;


use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/h', [ReportController::class, 'generateHomePageReport'])->name('home.reports');
Route::get('/category', [ReportController::class, 'generateCategoryPageReport'])->name('category.reports');






Route::get('/', HomePage::class)->name('home.page');
Route::get('/categorys', Categorys::class)->name('home.categorys');


Route::prefix('projects-live')->name('projects-live.')->group(function () {
    Route::get('/', ProjectsIndex::class)->name('index');
    Route::get('/create', ProjectsCreate::class)->name('create');
    Route::get('/{project}', ProjectsShow::class)->name('show');
    Route::get('/{project}/edit', ProjectsEdit::class)->name('edit');
});


Route::prefix('departments-live')->name('departments-live.')->group(function () {
    Route::get('/', DepartmentsIndex::class)->name('index');
    Route::get('/create', DepartmentsCreate::class)->name('create');
    Route::get('/{department}', DepartmentsShow::class)->name('show');
    Route::get('/{department}/edit', DepartmentsEdit::class)->name('edit');
});


Route::prefix('supervisors-live')->name('supervisors-live.')->group(function () {
    Route::get('/', SupervisorsIndex::class)->name('index');
    Route::get('/create', SupervisorsCreate::class)->name('create');
    Route::get('/{supervisor}', SupervisorsShow::class)->name('show');
    Route::get('/{supervisor}/edit', SupervisorsEdit::class)->name('edit');
});





Route::apiResource('departments', DepartmentController::class);
Route::apiResource('supervisors', SupervisorController::class);
Route::apiResource('projects', ProjectController::class);
