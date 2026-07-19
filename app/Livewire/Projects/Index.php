<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\Department;
use App\Models\Supervisor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;


    #[Url(history: true)]
    public $search = '';

    #[Url(history: true, except: '')]
    public $year;

    #[Url(history: true, except: '')]
    public $department_id;

    #[Url(history: true, except: '')]
    public $supervisor_id;

    #[Url(history: true, except: '')]
    public $is_active;


    public $departments;
    public $supervisors;

    public function mount()
    {
        $this->departments = Department::orderBy('name')->get();
        $this->supervisors = Supervisor::orderBy('name')->get();
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
        $this->year = null;
        $this->department_id = null;
        $this->supervisor_id = null;
        $this->is_active = null;
        $this->resetPage();
    }

    public function render()
    {

        $projects = Project::with('supervisor:id,name', 'department:id,name')
            ->filter([
                'search' => $this->search,
                'year' => $this->year,
                'department_id' => $this->department_id,
                'supervisor_id' => $this->supervisor_id,
                'is_archiv' => $this->is_active,
            ])
            ->paginate(12)
            ->withQueryString();


        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 18);

        return view('livewire.projects.index', [
            'projects' => $projects,
            'departments' => $this->departments,
            'supervisors' => $this->supervisors,
            'years' => $years,
        ]);
    }
}



