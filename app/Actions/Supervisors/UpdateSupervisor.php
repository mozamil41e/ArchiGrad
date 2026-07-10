<?php

namespace App\Actions\Supervisors;

use App\Livewire\Forms\SupervisorForm;
use App\Models\Supervisor;

class UpdateSupervisor
{
    public function execute(Supervisor $supervisor, SupervisorForm $form): Supervisor
    {
        $supervisor->update([
            'name' => $form->name,
            'department_id' => $form->department_id,
        ]);

        return $supervisor;
    }
}
