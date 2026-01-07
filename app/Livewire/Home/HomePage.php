<?php

namespace App\Livewire\Home;

use App\Models\Department;
use App\Models\Project;
use App\Models\Student;
use Livewire\Component;


class HomePage extends Component
{

    public $archived_projects;
    public $new_projects;
    public $total_departments;
    public $distinct_years;
    public $total_students;

    public function mount()
    {

        $this->archived_projects = $this->countProjectsIsArchive();
        $this->new_projects = $this->countNewProjects();
        $this->total_departments = $this->countDepartments();
        $this->distinct_years = $this->countYears();
        $this->total_students = $this->countStudents();
    }

    public function countProjectsIsArchive()
    {
        return Project::where('is_archiv', true)->count();
    }
    public function countNewProjects()
    {
        return Project::where('is_archiv', false)->count();
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

    public function countYears()
    {
        return Project::distinct('year')->count();
    }

    public function render()
    {
        return view('livewire.home.home-page', [
            'archived_projects' => $this->archived_projects,
            'new_projects' => $this->new_projects,
            'total_departments' => $this->total_departments,
            'distinct_years' => $this->distinct_years,
            'total_students' => $this->total_students,
        ]);
    }
}
