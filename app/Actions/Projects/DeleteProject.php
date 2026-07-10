<?php

namespace App\Actions\Projects;

use App\Models\Project;

class DeleteProject
{
    public function execute(Project $project): void
    {
        $project->delete();
    }
}
