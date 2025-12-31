<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Build query with filters
        $query = Project::with('supervisor:id,name', 'department');

        // Apply search filter (title)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Apply year filter
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Apply department filter
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Apply supervisor filter
        if ($request->filled('supervisor_id')) {
            $query->where('supervisor_id', $request->supervisor_id);
        }

        // Paginate results (after filtering)
        $projects = $query->paginate(12)->withQueryString();

        // Get filter options for dropdowns
        $departments = \App\Models\Department::orderBy('name')->get();
        $supervisors = \App\Models\Supervisor::orderBy('name')->get();

        // Generate years for dropdown (last 10 years)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 9);

        return view('projects.index', compact('projects', 'departments', 'supervisors', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('supervisor', 'department', 'students')->findOrFail($id);
        // return $project;
        return view('projects.details', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
