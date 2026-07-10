<?php

namespace App\Livewire\Projects;

use App\Actions\Projects\ArchiveProject;
use App\Actions\Projects\UnarchiveProject;
use App\Exceptions\ProjectArchivingException;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Show extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project->load(
            'department',
            'supervisor',
            'students'
        );
    }

    public function archiveProject(ArchiveProject $archiveProject)
    {
        abort_unless(auth()->check(), 403);

        try {
            $archiveProject->execute($this->project);
        } catch (ProjectArchivingException $e) {
            session()->flash('error', $e->getMessage());

            return;
        }

        session()->flash('message', 'تم أرشفة المشروع بنجاح');
        $this->dispatch('project-archived');
    }

    public function unarchiveProject(UnarchiveProject $unarchiveProject)
    {
        abort_unless(auth()->check(), 403);

        $unarchiveProject->execute($this->project);

        session()->flash('message', 'تم إلغاء أرشفة المشروع بنجاح');
    }

    public function downloadPdf()
    {
        if ($this->project->file_path && Storage::disk('public')->exists($this->project->file_path)) {
            return Storage::disk('public')->download(
                $this->project->file_path,
                $this->project->title . '.pdf'
            );
        }

        session()->flash('error', 'عذراً، الملف غير موجود حالياً.');
    }

    public function render()
    {
        return view('livewire.projects.show', ['project' => $this->project])
            ->layout('components.layouts.app', ['title' => $this->project->title]);
    }
}
