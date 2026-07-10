<?php

namespace App\Actions\Departments;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;

class UpdateDepartment
{
    public function execute(Department $department, DepartmentForm $form): Department
    {
        $department->update(['name' => $form->name]);

        return $department;
    }
}
