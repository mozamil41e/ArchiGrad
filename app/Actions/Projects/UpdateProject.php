<?php

namespace App\Actions\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class UpdateProject
{
    public function __construct(private SyncProjectStudents $syncStudents)
    {
    }

    public function execute(Project $project, ProjectForm $form): Project
    {
        $data = [
            'title' => $form->title,
            'description' => $form->summary,
            'supervisor_id' => $form->supervisor_id,
            'department_id' => $form->department_id,
            'year' => $form->year,
            'submission_deadline' => $form->defenseDate,
            'grade' => $form->grade,
        ];

        if ($form->pdfFile) {
            if ($project->file_path) {
                Storage::disk('public')->delete($project->file_path);
            }
            $data['file_path'] = $form->pdfFile->store('projects', 'public');
        }

        $project->update($data);

        $this->syncStudents->execute($project, $form->students, $form->department_id);

        return $project;
    }
}
