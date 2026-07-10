<?php

namespace App\Actions\Supervisors;

use App\Livewire\Forms\SupervisorForm;
use App\Models\Supervisor;

class CreateSupervisor
{
    public function execute(SupervisorForm $form): Supervisor
    {
        return Supervisor::create([
            'name' => $form->name,
            'department_id' => $form->department_id,
        ]);
    }
}
