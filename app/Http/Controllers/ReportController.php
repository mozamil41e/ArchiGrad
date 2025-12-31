<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function generateHomePageReport()
    {
        $reportData = [
            'archived_projects' => $this->countProjectsIsArchive(),
            'new_projects' => $this->countNewProjects(),
            'total_departments' => $this->countDepartments(),
            'distinct_years' => $this->countYears(),
            'total_students' => $this->countStudents(),
        ];
        return view('home', $reportData);
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

    ////////////////////////////////////////////
    //// Other report methods can be added here ////
    ////////////////////////////////////////////
    public function generateCategoryPageReport()
    {
        $reportData = [
            'department_Categories' => $this->countProjectsOfDepartments(),
            'year_Categories' => $this->countProjectsOfYears(),
            'total_departments' => $this->countDepartments(),
            'total_projects' => $this->countProjects(),
            'total_students' => $this->countStudents(),
        ];
        return view('category', $reportData);
    }

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
}
