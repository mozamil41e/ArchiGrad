<?php

namespace App\Actions\Departments;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;

class CreateDepartment
{
    public function execute(DepartmentForm $form): Department
    {
        return Department::create(['name' => $form->name]);
    }
}
