<?php

namespace App\Actions\Projects;

use App\Enums\Grade;
use App\Livewire\Forms\ProjectForm;
use App\Models\Project;

class CreateProject
{
    public function __construct(private SyncProjectStudents $syncStudents)
    {
    }

    public function execute(ProjectForm $form): Project
    {
        $project = Project::create([
            'title' => $form->title,
            'description' => $form->summary,
            'supervisor_id' => $form->supervisor_id,
            'department_id' => $form->department_id,
            'year' => $form->year,
            'submission_deadline' => $form->defenseDate,
            'grade' => Grade::Pending->value,
            'is_archiv' => false,
            'file_path' => $form->pdfFile?->store('projects', 'public'),
        ]);

        $this->syncStudents->execute($project, $form->students, $form->department_id);

        return $project;
    }
}
