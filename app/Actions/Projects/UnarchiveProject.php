<?php

namespace App\Actions\Projects;

use App\Models\Project;

class UnarchiveProject
{
    public function execute(Project $project): void
    {
        $project->update(['is_archiv' => false]);
    }
}
