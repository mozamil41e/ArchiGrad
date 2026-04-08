<?php

namespace App\Livewire\Projects;

use App\Models\Department;
use App\Models\Project;
use App\Models\Student;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithFileUploads;

    #[Locked]
    public $projectId;

    public $currentStep = 1;

    // Step 1 - Basic Information
    public $title = '';
    public $summary = '';

    // Step 2 - Additional Details
    public $students = [];
    public $universityNumbers = [];
    public $supervisor_id = '';
    public $year = '';
    public $department_id = '';
    public $defenseDate = '';
    public $grade = '';
    // public $keywords = '';
    public $pdfFile;

    // Dropdown data
    public $supervisors = [];
    public $departments = [];
    public $years = [];

    public function mount(Project $project = null)
    {
        $this->projectId = $project?->id;

        // Load dropdown data
        $this->supervisors = Supervisor::all();
        $this->departments = Department::all();

        // Generate years (current year and previous 5 years)
        $currentYear = Carbon::now()->year;
        $this->years = collect(range($currentYear, $currentYear - 5))
            ->map(fn($year) => $year . '-' . ($year + 1))
            ->toArray();

        // Initialize students array
        $this->students = [''];
        $this->universityNumbers = [''];

        // If editing existing project, load data
        if ($project) {
            $this->loadProjectData($project);
        }
    }

    public function loadProjectData(Project $project)
    {
        $this->title = $project->title;
        $this->summary = $project->description;
        $this->supervisor_id = $project->supervisor_id;
        $this->year = $project->year;
        $this->department_id = $project->department_id;
        $this->defenseDate = $project->submission_deadline?->format('Y-m-d') ?? '';
        $this->grade = $project->grade;
        // $this->keywords = $project->keywords ?? '';

        // Load students - eager load or lazy load
        $students = $project->students()->pluck('name')->toArray();
        $this->students = !empty($students) ? $students : [''];

        // Load university numbers
        $universities = $project->students()->pluck('university_number')->toArray();
        $this->universityNumbers = !empty($universities) ? $universities : [''];
    }

    public function nextStep()
    {
        $this->validate([
            'title' => 'required|string|max:150',
            'summary' => 'required|string|min:100',
        ]);

        $this->currentStep = 2;
    }

    public function previousStep()
    {
        $this->currentStep = 1;
    }

    public function addStudent()
    {
        $this->students[] = '';
        $this->universityNumbers[] = '';
    }

    public function removeStudent($index)
    {
        unset($this->students[$index]);
        unset($this->universityNumbers[$index]);
        $this->students = array_values($this->students);
        $this->universityNumbers = array_values($this->universityNumbers);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:150',
            'summary' => 'required|string|min:100',
            'students' => 'required|array|min:1',
            'students.*' => 'required|string|min:2',
            'universityNumbers' => 'required|array|min:1',
            'universityNumbers.*' => 'required|string|min:3',
            'supervisor_id' => 'required|exists:supervisors,id',
            'year' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'defenseDate' => 'required|date',
            'grade' => 'required|in:A,B+,C+,C',
            // 'keywords' => 'required|string',
            'pdfFile' => $this->projectId ? 'nullable|mimes:pdf|max:10240' : 'required|mimes:pdf|max:10240',
        ]);

        try {
            $projectData = [
                'title' => $this->title,
                'description' => $this->summary,
                'supervisor_id' => $this->supervisor_id,
                'year' => $this->year,
                'department_id' => $this->department_id,
                'submission_deadline' => $this->defenseDate,
                'grade' => $this->grade,
                // 'keywords' => $this->keywords,
            ];

            if ($this->projectId) {
                // Update existing project
                $project = Project::findOrFail($this->projectId);

                if ($this->pdfFile) {
                    if ($project->file_path) {
                        Storage::disk('public')->delete($project->file_path);
                    }
                    $projectData['file_path'] = $this->pdfFile->store('projects', 'public');
                }

                $project->update($projectData);

                // Update students
                $project->students()->delete();
                foreach ($this->students as $index => $studentName) {
                    Student::create([
                        'name' => $studentName,
                        'project_id' => $project->id,
                        'department_id' => $project->department_id,
                        'university_number' => $this->universityNumbers[$index] ?? '',
                    ]);
                }

                session()->flash('message', 'تم تحديث المشروع بنجاح');
            } else {
                // Create new project
                if ($this->pdfFile) {
                    $projectData['file_path'] = $this->pdfFile->store('projects', 'public');
                }

                $project = Project::create($projectData);

                // Create students
                foreach ($this->students as $index => $studentName) {
                    Student::create([
                        'name' => $studentName,
                        'project_id' => $project->id,
                        'department_id' => $project->department_id,
                        'university_number' => $this->universityNumbers[$index] ?? '',
                    ]);
                }

                session()->flash('message', 'تم حفظ المشروع بنجاح');
            }

            return redirect()->route('projects-live.show', $project->id);
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.projects.edit');
    }
}
