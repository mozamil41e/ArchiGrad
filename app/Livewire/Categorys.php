<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Categorys extends Component
{
    public function countProjectsOfDepartments()
    {
        return Cache::remember('departments_projects_count', 3600, function () {
            return Department::select('id', 'name')
                ->withCount('projects')
                ->get();
        });
    }

    public function countProjectsOfYears()
    {
        return Cache::remember('projects_count_by_year', 3600, function () {
            return Project::selectRaw('year, COUNT(*) as total')
                ->groupBy('year')
                ->orderByDesc('year')
                ->get();
        });
    }

    public function countDepartments()
    {
        return Department::count();
    }
    public function countProjects()
    {
        return Project::count();
    }
    public function countStudents()
    {
        return Student::count();
    }

    public function render()
    {
        $reportData = [
            'department_Categories' => $this->countProjectsOfDepartments(),
            'year_Categories' => $this->countProjectsOfYears(),
            'total_departments' => $this->countDepartments(),
            'total_projects' => $this->countProjects(),
            'total_students' => $this->countStudents(),
        ];
        return view('livewire.categorys', $reportData);
    }
}
