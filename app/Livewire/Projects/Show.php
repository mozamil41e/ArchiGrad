<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\Title;
use Livewire\Component;


class Show extends Component
{
    #[Title('عرض المشروع')]

    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project->load(
            'department',
            'supervisor',
            'students'
        );
    }


    public function render()
    {
        $project = $this->project->with('supervisor', 'department', 'students');
        return view('livewire.projects.show', compact('project'));
    }
}
