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

    public function archiveProject()
    {
        if (!auth()->check()) {
            abort(403);
        }

        $this->project->is_archiv = true;
        $this->project->save();

        session()->flash('message', 'تم أرشفة المشروع بنجاح');
        $this->dispatch('project-archived');
    }

    public function unarchiveProject()
    {
        if (!auth()->check()) {
            abort(403);
        }

        $this->project->is_archiv = false;
        $this->project->save();

        session()->flash('message', 'تم إلغاء أرشفة المشروع بنجاح');
        $this->dispatch('project-unarchived');
    }

    public function render()
    {
        $project = $this->project;
        return view('livewire.projects.show', compact('project'));
    }
}
