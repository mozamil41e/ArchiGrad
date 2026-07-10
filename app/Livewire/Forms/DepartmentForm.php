<?php

namespace App\Livewire\Forms;

use App\Models\Department;
use Illuminate\Validation\Rule;
use Livewire\Form;

class DepartmentForm extends Form
{
    public ?int $departmentId = null;
    public string $name = '';

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('departments', 'name')->ignore($this->departmentId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم القسم مطلوب.',
            'name.unique' => 'هذا القسم موجود مسبقاً.',
            'name.max' => 'اسم القسم يجب ألا يتجاوز 100 حرف.',
        ];
    }

    public function fromDepartment(Department $department): void
    {
        $this->departmentId = $department->id;
        $this->name = $department->name;
    }
}
