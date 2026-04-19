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

    #[Url(history: true)]
    public $year;

    #[Url(history: true)]
    public $department_id;

    #[Url(history: true)]
    public $supervisor_id;

    #[Url(history: true)]
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
        $years = range($currentYear, $currentYear - 19);

        return view('livewire.projects.index', [
            'projects' => $projects,
            'departments' => $this->departments,
            'supervisors' => $this->supervisors,
            'years' => $years,
        ]);
    }
}





// namespace App\Livewire\Projects;

// use App\Models\Project;
// use App\Models\Department;
// use App\Models\Supervisor;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Livewire\Attributes\Url;



// class Index extends Component
// {

//     use WithPagination;

//     #[Url(history: true)]
//     public $search = '';

//     #[Url(history: true)]
//     public $year = '';

//     #[Url(history: true)]
//     public $department_id = '';

//     #[Url(history: true)]
//     public $supervisor_id = '';

//     public function mount()
//     {
//         // تهيئة الخصائص من الـ request إذا كانت موجودة
//         $this->search = request('search', $this->search);
//         $this->year = request('year', $this->year);
//         $this->department_id = request('department_id', $this->department_id);
//         $this->supervisor_id = request('supervisor_id', $this->supervisor_id);
//     }

//     public function updated($property)
//     {
//         if (in_array($property, ['search', 'year', 'department_id', 'supervisor_id'])) {
//             $this->resetPage();
//         }
//     }

//     public function resetFilters()
//     {
//         $this->search = '';
//         $this->year = '';
//         $this->department_id = '';
//         $this->supervisor_id = '';
//         $this->resetPage();
//     }

//     public function render()
//     {
//         $query = Project::with('supervisor:id,name', 'department:id,name');

//         if ($this->search) {
//             $query->where('title', 'like', '%' . $this->search . '%')
//                 ->orWhere('description', 'like', '%' . $this->search . '%');
//         }

//         if ($this->year) {
//             $query->where('year', $this->year);
//         }

//         if ($this->department_id) {
//             $query->where('department_id', $this->department_id);
//         }

//         if ($this->supervisor_id) {
//             $query->where('supervisor_id', $this->supervisor_id);
//         }

//         $projects = $query->paginate(12);

//         $departments = Department::orderBy('name')->get();
//         $supervisors = Supervisor::orderBy('name')->get();

//         $currentYear = date('Y');
//         $years = range($currentYear, $currentYear - 19);
//         return view('livewire.projects.index', compact('projects', 'departments', 'supervisors', 'years'));
//     }
// }
