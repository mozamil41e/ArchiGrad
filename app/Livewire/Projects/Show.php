<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
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



    public function archiveProject()
    {
        if (!auth()->check()) {
            abort(403);
        }
        if($this->project->file_path == null) {
            session()->flash('error', 'عذراً، لا يمكن أرشفة المشروع بدون ملف');
            return;
        }
        if($this->project->grade == "pending") {
            session()->flash('error', 'عذراً، لا يمكن أرشفة المشروع بدون درجة');
            return;
        }
        if(Storage::disk('public')->exists($this->project->file_path) == false) {
            session()->flash('error', 'عذراً، الملف غير موجود حالياً');
            return;
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

       return session()->flash('message', 'تم إلغاء أرشفة المشروع بنجاح');
    }

// download pdf function

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
        $project = $this->project;
        if($project->grade == "pending") {
            $project->grade = "لم يتم التقييم بعد";
        }
        return view('livewire.projects.show', compact('project'))->layout('components.layouts.app', [
            'title' => $project->title
        ]);
    }
}
