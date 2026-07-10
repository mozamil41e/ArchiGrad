<?php

namespace App\Actions\Departments;

use App\Models\Department;

class DeleteDepartment
{
    public function execute(Department $department): void
    {
        $department->delete();
    }
}
