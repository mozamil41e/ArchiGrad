<?php

namespace App\Livewire\Projects;

use App\Actions\Projects\CheckProjectTitleSimilarity;
use App\Actions\Projects\CreateProject;
use App\Livewire\Forms\ProjectForm;
use App\Models\Department;
use App\Models\Project;
use App\Models\Supervisor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Model;
use Livewire\Component;
use Livewire\WithFileUploads;


class Create extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public int $currentStep = 1;

    public ProjectForm $form;

    public array $similarProjects = [];

    public $supervisors = [];
    public $departments = [];
    public $years = [];

    private CheckProjectTitleSimilarity $similarity;


    public function boot(CheckProjectTitleSimilarity $similarity)
    {
        $this->similarity = $similarity;
    }


    public function mount()
    {
        $this->supervisors = Supervisor::all();
        $this->departments = Department::all();

        $currentYear = (int) date('Y');
        $this->years = range($currentYear, $currentYear - 4);
    }

    public function updatedFormTitle(string $value)
    {
        $this->similarProjects = strlen($value) > 5
            ? $this->similarity->search($value)
            : [];
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
        $this->resetErrorBag();
    }

    public function save(CheckProjectTitleSimilarity $checkSimilarity, CreateProject $createProject)
    {
        $this->authorize('create');
        if ($checkSimilarity->search($this->form->title) !== []) {
            session()->flash('error', 'هذا العنوان مشابه لعناوين مشاريع سابقة، يرجى اختيار عنوان آخر.');

            return $this->redirectRoute('projects-live.create', navigate: true);
        }

        $this->form->validate();

        $createProject->execute($this->form);

        session()->flash('message', 'تم حفظ المشروع بنجاح!');

        return $this->redirectRoute('projects-live.create', navigate: true);
    }

    public function render()
    {
        return view('livewire.projects.create');
    }
}
