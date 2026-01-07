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
        $query = Project::with('supervisor:id,name', 'department:id,name');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
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
        return view('livewire.projects.index', compact('projects', 'departments', 'supervisors', 'years'));
    }
}




// namespace App\Http\Livewire\Projects;

// use Livewire\Component;
// use App\Models\Project;
// use App\Models\Department;
// use App\Models\Supervisor;
// use Illuminate\Support\Collection;

// class ProjectIndex extends Component
// {
//     public string $search = '';
//     public ?int $year = null;
//     public ?int $department_id = null;
//     public ?int $supervisor_id = null;

//     protected const PAGINATION_PER_PAGE = 12;
//     protected const YEARS_RANGE = 19;

//     public function render()
//     {
//         return view('livewire.projects.index', [
//             'projects' => $this->getFilteredProjects(),
//             'departments' => $this->getDepartments(),
//             'supervisors' => $this->getSupervisors(),
//             'years' => $this->getYears(),
//         ]);
//     }

//     private function getFilteredProjects()
//     {
//         $query = Project::with([
//             'supervisor:id,name',
//             'department:id,name'
//         ]);

//         $this->applyFilters($query);

//         return $query->paginate(self::PAGINATION_PER_PAGE);
//     }

//     private function applyFilters($query): void
//     {
//         if ($this->hasSearch()) {
//             $this->applySearchFilter($query);
//         }

//         if ($this->hasYearFilter()) {
//             $query->where('year', $this->year);
//         }

//         if ($this->hasDepartmentFilter()) {
//             $query->where('department_id', $this->department_id);
//         }

//         if ($this->hasSupervisorFilter()) {
//             $query->where('supervisor_id', $this->supervisor_id);
//         }
//     }

//     private function applySearchFilter($query): void
//     {
//         $searchTerm = "%{$this->search}%";

//         $query->where(function ($q) use ($searchTerm) {
//             $q->where('title', 'like', $searchTerm)
//               ->orWhere('description', 'like', $searchTerm);
//         });
//     }

//     private function getDepartments(): Collection
//     {
//         return Department::orderBy('name')->get(['id', 'name']);
//     }

//     private function getSupervisors(): Collection
//     {
//         return Supervisor::orderBy('name')->get(['id', 'name']);
//     }

//     private function getYears(): array
//     {
//         $currentYear = now()->year;
//         return range($currentYear, $currentYear - self::YEARS_RANGE);
//     }

//     private function hasSearch(): bool
//     {
//         return !empty($this->search);
//     }

//     private function hasYearFilter(): bool
//     {
//         return !is_null($this->year);
//     }

//     private function hasDepartmentFilter(): bool
//     {
//         return !is_null($this->department_id);
//     }

//     private function hasSupervisorFilter(): bool
//     {
//         return !is_null($this->supervisor_id);
//     }
// }
