<?php

namespace App\Livewire\Projects;

use App\Models\Department;
use App\Models\Project;
use App\Models\Supervisor;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // Form step
    public $currentStep = 1;

    // Step 1 fields
    public $title = '';
    public $summary = '';

    // Step 2 fields
    public $students = [['name' => '', 'university_number' => '']];
    public $supervisor_id = '';
    public $year = '';
    public $department_id = '';
    public $defenseDate = '';

    public $pdfFile;

    // Data for selects
    public $supervisors = [];
    public $departments = [];
    public $years = [];


    public array $existingProjects = [
        "نظام إدارة مشاريع التخرج",
        "تطبيق مكتبي لإدارة الطلاب",
        "نظام متابعة مشاريع بصات"
    ];

    public string $newTitle = "نظام متابعة مشاريع بصات";

    /**
     * تحقق من تشابه عنوان المشروع مع المشاريع السابقة
     *
     * @param string $newTitle العنوان الجديد
     * @param array $existingTitles مصفوفة عناوين المشاريع السابقة
     * @param int $threshold نسبة التشابه المئوية لمنع التكرار (مثلاً 70)
     * @return array يحتوي على المشاريع المشابهة مع نسبة التشابه
     */
    function checkProjectSimilarity(string $newTitle, array $existingTitles, int $threshold = 70): array
    {
        $similarProjects = [];

        foreach ($existingTitles as $title) {
            // استخدام similar_text لحساب نسبة التشابه
            similar_text($newTitle, $title, $percent);

            // إذا كانت النسبة أكبر من الحد المسموح
            if ($percent >= $threshold) {
                $similarProjects[] = [
                    'existing_title' => $title,
                    'similarity' => round($percent, 2) // تقريب النسبة
                ];
            }
        }

        empty($similarProjects) ? $similarProjects['pass'] = true :  $similarProjects['pass'] = false;

        return $similarProjects;
    }

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:150',
            'summary' => 'required|string|min:100',
        ];

        if ($this->currentStep === 2) {
            $rules = array_merge($rules, [
                'students' => 'required|array|min:1',
                'students.*.name' => 'required|string|max:255',
                'students.*.university_number' => 'required|size:10',
                'supervisor_id' => 'required|exists:supervisors,id',
                'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
                'department_id' => 'required|exists:departments,id',
                'defenseDate' => 'required|date',
            ]);
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'عنوان المشروع مطلوب',
        'title.max' => 'عنوان المشروع يجب أن لا يتجاوز 150 حرف',
        'summary.required' => 'ملخص المشروع مطلوب',
        'summary.min' => 'ملخص المشروع يجب أن يكون 100 حرف على الأقل',
        'students.required' => 'يجب إدخال بيانات طالب واحد على الأقل',
        'students.*.name.required' => 'اسم الطالب مطلوب',
        'students.*.university_number.required' => 'الرقم الجامعي مطلوب',
        'students.*.university_number.size' => 'الرقم الجامعي يجب أن يكون 10 أرقام',
        'supervisor_id.required' => 'المشرف مطلوب',
        'supervisor_id.exists' => 'المشرف المحدد غير موجود',
        'year.required' => 'السنة الأكاديمية مطلوبة',
        'department_id.required' => 'التخصص مطلوب',
        'department_id.exists' => 'التخصص المحدد غير موجود',
        'defenseDate.required' => 'تاريخ المناقشة مطلوب',
        'defenseDate.date' => 'تاريخ المناقشة غير صحيح',
    ];

    public function mount()
    {
        // Load supervisors and departments
        $this->supervisors = Supervisor::all();
        $this->departments = Department::all();
        $this->existingProjects = Project::pluck('title')->toArray();

        // Generate years (current year and 4 previous years)
        $currentYear = date('Y');
        for ($i = 0; $i < 5; $i++) {
            $this->years[] = $currentYear - $i;
        }
    }

    public function addStudent()
    {
        $this->students[] = ['name' => '', 'university_number' => ''];
    }

    public function removeStudent($index)
    {
        if (count($this->students) > 1) {
            unset($this->students[$index]);
            $this->students = array_values($this->students); // Re-index array
        }
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
        $this->resetErrorBag();
    }

    public function save()
    {

        if (!$this->checkProjectSimilarity($this->title, $this->existingProjects)['pass']) {
            session()->flash('error', 'هذا العنوان مشابه لعناوين مشاريع سابقة، يرجى اختيار عنوان آخر.');
            return $this->redirectRoute('projects-live.create', navigate: true);
        }

        $this->validate();

        try {
            // Prepare description (combine summary and keywords)
            $description = $this->summary;


            // Upload PDF file
            $pdfPath = null;
            if ($this->pdfFile) {
                $fileName = time() . '.pdf';
                $pdfPath = $this->pdfFile->storeAs(
                    'projects',
                    $fileName,
                    'public'
                );
            }

            // Create project
            $project = Project::create([
                'title' => $this->title,
                'description' => $description,
                'supervisor_id' => $this->supervisor_id,
                'department_id' => $this->department_id,
                'year' => $this->year,
                'submission_deadline' => $this->defenseDate,
                'file_path' => $pdfPath,
                'grade' => "pending",
                'is_archiv' => false,
            ]);

            // Create students
            foreach ($this->students as $studentData) {
                if (trim($studentData['name']) && trim($studentData['university_number'])) {
                    Student::create([
                        'name' => trim($studentData['name']),
                        'project_id' => $project->id,
                        'department_id' => $this->department_id,
                        'university_number' => trim($studentData['university_number']),
                    ]);
                }
            }


            // Redirect to projects index with success message
            session()->flash('message', 'تم حفظ المشروع بنجاح!');

            return $this->redirectRoute('projects-live.create', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء حفظ المشروع: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.projects.create');
    }
}
