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
        $this->departments = Department::all();
        $this->supervisors = collect();

        // Generate years (current year and previous 5 years)
        $currentYear = Carbon::now()->year;
        $this->years = collect(range($currentYear, $currentYear - 5))
            ->toArray();

        // Initialize students array
        $this->students = [''];
        $this->universityNumbers = [''];

        // If editing existing project, load data
        if ($project) {
            $this->loadProjectData($project);
            $this->supervisors = Supervisor::where('department_id', $this->department_id)->get();
        }
    }

    public function updatedDepartmentId($value)
    {
        if ($value) {
            $this->supervisors = Supervisor::where('department_id', $value)->get();
        } else {
            $this->supervisors = collect();
        }
        $this->supervisor_id = '';
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
            'students' => 'nullable|array|min:1',
            'students.*' => 'nullable|string|min:2',
            'universityNumbers' => 'nullable|array|min:1',
            'universityNumbers.*' => [
                'nullable',
                'string',
                'min:11',
                'distinct',
                Rule::unique('students', 'university_number')->whereNot('project_id', $this->projectId),
            ],
            'supervisor_id' => 'required|exists:supervisors,id',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'department_id' => 'required|exists:departments,id',
            'defenseDate' => 'required|date',
            'grade' => 'required|in:A,B+,B,C+,C,F,pending',
            // 'keywords' => 'required|string',
            'pdfFile' => $this->projectId ? 'nullable|mimes:pdf|max:10240' : 'required|mimes:pdf|max:10240',
        ],[
        'title.required' => 'عنوان المشروع مطلوب',
        'title.max' => 'عنوان المشروع يجب أن لا يتجاوز 150 حرف',
        'summary.required' => 'ملخص المشروع مطلوب',
        'summary.min' => 'ملخص المشروع يجب أن يكون 100 حرف على الأقل',
        'students.required' => 'يجب إدخال بيانات طالب واحد على الأقل',
        'students.*.required' => 'اسم الطالب مطلوب',
        'students.*.min' => 'اسم الطالب يجب أن يكون حرفين على الأقل',
        'universityNumbers.required' => 'الرقم الجامعي مطلوب',
        'universityNumbers.*.required' => 'الرقم الجامعي مطلوب',
        'universityNumbers.*.unique' => 'الرقم الجامعي موجود بالفعل',
        'universityNumbers.*.min' => 'الرقم الجامعي يجب أن يكون 11 أرقام على الأقل',
        'universityNumbers.*.distinct' => 'الرقم الجامعي مكرر في النموذج',
        'supervisor_id.required' => 'المشرف مطلوب',
        'supervisor_id.exists' => 'المشرف المحدد غير موجود',
        'year.required' => 'السنة الأكاديمية مطلوبة',
        'department_id.required' => 'التخصص مطلوب',
        'department_id.exists' => 'التخصص المحدد غير موجود',
        'defenseDate.required' => 'تاريخ المناقشة مطلوب',
        'defenseDate.date' => 'تاريخ المناقشة غير صحيح',
        'pdfFile.mimes' => 'الملف يجب أن يكون بصيغة PDF',
        'pdfFile.max' => 'الملف يجب أن لا يتجاوز 10 ميجابايت',
    ],);


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
