<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Department;
use App\Models\Supervisor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ProjectsList extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $year = '';

    #[Url(history: true)]
    public $department_id = '';

    #[Url(history: true)]
    public $supervisor_id = '';

    public function mount()
    {
        // تهيئة الخصائص من الـ request إذا كانت موجودة
        $this->search = request('search', $this->search);
        $this->year = request('year', $this->year);
        $this->department_id = request('department_id', $this->department_id);
        $this->supervisor_id = request('supervisor_id', $this->supervisor_id);
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'year', 'department_id', 'supervisor_id'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->year = '';
        $this->department_id = '';
        $this->supervisor_id = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Project::with('supervisor:id,name', 'department');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->year) {
            $query->where('year', $this->year);
        }

        if ($this->department_id) {
            $query->where('department_id', $this->department_id);
        }

        if ($this->supervisor_id) {
            $query->where('supervisor_id', $this->supervisor_id);
        }

        $projects = $query->paginate(12);

        $departments = Department::orderBy('name')->get();
        $supervisors = Supervisor::orderBy('name')->get();

        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 19);

        return view('livewire.projects-list', compact('projects', 'departments', 'supervisors', 'years'));
    }
}
