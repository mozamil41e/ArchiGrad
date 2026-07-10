<?php

namespace App\Actions\Supervisors;

use App\Models\Supervisor;

class DeleteSupervisor
{
    public function execute(Supervisor $supervisor): void
    {
        $supervisor->delete();
    }
}
