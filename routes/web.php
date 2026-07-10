<?php

use App\Livewire\Auth\LoginApp;
use App\Livewire\Auth\Logout;

use App\Livewire\Departments\Index as DepartmentsIndex;

use App\Livewire\Home\Categorys;
use App\Livewire\Home\HomePage;
use App\Livewire\Projects\Create as ProjectsCreate;
use App\Livewire\Projects\Edit as ProjectsEdit;

use App\Livewire\Projects\Index as ProjectsIndex;
use App\Livewire\Projects\Show as ProjectsShow;

use App\Livewire\Supervisors\Index as SupervisorsIndex;

use Illuminate\Support\Facades\Route;

Route::get('/login', LoginApp::class)->name('login');


Route::get('/', HomePage::class)->name('home.page');
Route::get('/categorys', Categorys::class)->name('home.categorys');


Route::middleware('auth')->group(function () {


    Route::prefix('projects-live')->name('projects-live.')->group(function () {
        Route::get('/', ProjectsIndex::class)->name('index')->withoutMiddleware('auth');
        Route::get('/create', ProjectsCreate::class)->name('create');
        Route::get('/{project}', ProjectsShow::class)->name('show')->withoutMiddleware('auth');
        Route::get('/{project}/edit', ProjectsEdit::class)->name('edit');
    });


    Route::prefix('departments-live')->name('departments-live.')->group(function () {
        Route::get('/', DepartmentsIndex::class)->name('index');
    });


    Route::prefix('supervisors-live')->name('supervisors-live.')->group(function () {
        Route::get('/', SupervisorsIndex::class)->name('index');
    });


    Route::prefix('reports-live')->name('reports-live.')->group(function () {
        Route::get('/', \App\Livewire\Reports\Index::class)->name('index');
    });



    Route::post('/logout', [Logout::class, 'logout'])->name('logout');
});

