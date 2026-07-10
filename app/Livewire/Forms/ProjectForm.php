<?php

namespace App\Livewire\Forms;

use App\Enums\Grade;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ProjectForm extends Form
{
    public ?int $projectId = null;

    public string $title = '';
    public string $summary = '';
    public array $students = [['name' => '', 'university_number' => '']];
    public string $supervisor_id = '';
    public string $year = '';
    public string $department_id = '';
    public string $defenseDate = '';
    public string $grade = 'pending';
    public $pdfFile = null;

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'summary' => 'required|string|min:100',
            'students' => 'nullable|array|min:1',
            'students.*.name' => 'nullable|string|max:255',
            'students.*.university_number' => [
                'nullable',
                'digits:11',
                'distinct',
                Rule::unique('students', 'university_number')
                    ->when($this->projectId, fn ($rule) => $rule->whereNot('project_id', $this->projectId)),
            ],
            'supervisor_id' => 'required|exists:supervisors,id',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'department_id' => 'required|exists:departments,id',
            'defenseDate' => 'required|date',
            'grade' => 'required|' . Grade::validationRule(),
            'pdfFile' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان المشروع مطلوب',
            'title.max' => 'عنوان المشروع يجب أن لا يتجاوز 150 حرف',
            'summary.required' => 'ملخص المشروع مطلوب',
            'summary.min' => 'ملخص المشروع يجب أن يكون 100 حرف على الأقل',
            'students.*.name.max' => 'اسم الطالب طويل جدًا',
            'students.*.university_number.digits' => 'الرقم الجامعي يجب أن يتكوّن من 11 رقمًا',
            'students.*.university_number.distinct' => 'الرقم الجامعي مكرر في النموذج',
            'students.*.university_number.unique' => 'الرقم الجامعي موجود بالفعل',
            'supervisor_id.required' => 'المشرف مطلوب',
            'supervisor_id.exists' => 'المشرف المحدد غير موجود',
            'year.required' => 'السنة الأكاديمية مطلوبة',
            'department_id.required' => 'التخصص مطلوب',
            'department_id.exists' => 'التخصص المحدد غير موجود',
            'defenseDate.required' => 'تاريخ المناقشة مطلوب',
            'defenseDate.date' => 'تاريخ المناقشة غير صحيح',
            'grade.required' => 'التقدير مطلوب',
            'grade.in' => 'التقدير المحدد غير صحيح',
            'pdfFile.mimes' => 'الملف يجب أن يكون بصيغة PDF',
            'pdfFile.max' => 'حجم الملف يجب أن لا يتجاوز 10 ميجابايت',
        ];
    }

    public function fromProject(Project $project): void
    {
        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->summary = $project->description;
        $this->supervisor_id = (string) $project->supervisor_id;
        $this->year = (string) $project->year;
        $this->department_id = (string) $project->department_id;
        $this->defenseDate = $project->submission_deadline?->format('Y-m-d') ?? '';
        $this->grade = $project->grade->value;

        $students = $project->students()->get(['name', 'university_number']);
        $this->students = $students->isNotEmpty()
            ? $students->map(fn ($student) => [
                'name' => $student->name,
                'university_number' => $student->university_number,
            ])->all()
            : [['name' => '', 'university_number' => '']];
    }

    public function addStudent(): void
    {
        $this->students[] = ['name' => '', 'university_number' => ''];
    }

    public function removeStudent(int $index): void
    {
        if (count($this->students) > 1) {
            unset($this->students[$index]);
            $this->students = array_values($this->students);
        }
    }
}
