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
    public $students = [''];
    public $supervisor_id = '';
    public $year = '';
    public $department_id = '';
    public $defenseDate = '';
    public $grade = '';
    public $keywords = '';
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
                'students.*' => 'required|string|max:255',
                'supervisor_id' => 'required|exists:supervisors,id',
                'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
                'department_id' => 'required|exists:departments,id',
                'defenseDate' => 'required|date',
                'grade' => 'required|in:A,B+,C+,C,F',
                'keywords' => 'nullable|string|max:500',
                'pdfFile' => 'required|file|mimes:pdf|max:10240', // 10MB max
            ]);
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'عنوان المشروع مطلوب',
        'title.max' => 'عنوان المشروع يجب أن لا يتجاوز 150 حرف',
        'summary.required' => 'ملخص المشروع مطلوب',
        'summary.min' => 'ملخص المشروع يجب أن يكون 100 حرف على الأقل',
        'students.required' => 'يجب إدخال اسم طالب واحد على الأقل',
        'students.*.required' => 'اسم الطالب مطلوب',
        'supervisor_id.required' => 'المشرف مطلوب',
        'supervisor_id.exists' => 'المشرف المحدد غير موجود',
        'year.required' => 'السنة الأكاديمية مطلوبة',
        'department_id.required' => 'التخصص مطلوب',
        'department_id.exists' => 'التخصص المحدد غير موجود',
        'defenseDate.required' => 'تاريخ المناقشة مطلوب',
        'defenseDate.date' => 'تاريخ المناقشة غير صحيح',
        'grade.required' => 'التقدير مطلوب',
        'grade.in' => 'التقدير المحدد غير صحيح',
        'pdfFile.required' => 'ملف PDF مطلوب',
        'pdfFile.mimes' => 'يجب أن يكون الملف بصيغة PDF',
        'pdfFile.max' => 'حجم الملف يجب أن لا يتجاوز 10MB',
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
        $this->students[] = '';
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
                'grade' => $this->grade,
                'is_archiv' => true,
            ]);

            // Create students
            $studentIndex = 0;
            foreach ($this->students as $studentName) {
                if (trim($studentName)) {
                    $studentIndex++;
                    // Generate a unique university number (you can customize this logic)
                    $universityNumber = 'STU-' . $this->year . '-' . $project->id . '-' . str_pad($studentIndex, 3, '0', STR_PAD_LEFT);

                    Student::create([
                        'name' => trim($studentName),
                        'project_id' => $project->id,
                        'department_id' => $this->department_id,
                        'university_number' => $universityNumber,
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
