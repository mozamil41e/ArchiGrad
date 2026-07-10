<?php

namespace App\Livewire\Projects;

use App\Actions\Projects\UpdateProject;
use App\Livewire\Forms\ProjectForm;
use App\Models\Department;
use App\Models\Project;
use App\Models\Supervisor;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    #[Locked]
    public Project $project;

    public int $currentStep = 1;

    public ProjectForm $form;

    public Collection $supervisors;
    public $departments = [];
    public $years = [];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->form->fromProject($project);

        $this->departments = Department::all();
        $this->supervisors = Supervisor::where('department_id', $project->department_id)->get();

        $currentYear = (int) date('Y');
        $this->years = range($currentYear, $currentYear - 5);
    }

    public function updatedFormDepartmentId($value)
    {
        $this->supervisors = $value
            ? Supervisor::where('department_id', $value)->get()
            : collect();

        $this->form->supervisor_id = '';
    }

    public function addStudent()
    {
        $this->form->addStudent();
    }

    public function removeStudent(int $index)
    {
        $this->form->removeStudent($index);
    }

    public function nextStep()
    {
        $this->form->validate([
            'title' => 'required|string|max:150',
            'summary' => 'required|string|min:100',
        ]);

        $this->currentStep = 2;
    }

    public function previousStep()
    {
        $this->currentStep = 1;
    }

    public function save(UpdateProject $updateProject)
    {
        $this->form->validate();

        $updateProject->execute($this->project, $this->form);

        session()->flash('message', 'تم تحديث المشروع بنجاح');

        return redirect()->route('projects-live.show', $this->project->id);
    }

    public function render()
    {
        return view('livewire.projects.edit');
    }
}
