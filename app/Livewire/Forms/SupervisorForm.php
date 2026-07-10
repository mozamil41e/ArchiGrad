<?php

namespace App\Livewire\Forms;

use App\Models\Supervisor;
use Illuminate\Validation\Rule;
use Livewire\Form;

class SupervisorForm extends Form
{
    public ?int $supervisorId = null;
    public string $name = '';
    public string $department_id = '';

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('supervisors', 'name')->ignore($this->supervisorId),
            ],
            'department_id' => 'required|exists:departments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المشرف مطلوب.',
            'name.unique' => 'هذا المشرف موجود مسبقاً.',
            'name.max' => 'اسم المشرف يجب ألا يتجاوز 100 حرف.',
            'department_id.required' => 'القسم مطلوب.',
            'department_id.exists' => 'القسم غير موجود.',
        ];
    }

    public function fromSupervisor(Supervisor $supervisor): void
    {
        $this->supervisorId = $supervisor->id;
        $this->name = $supervisor->name;
        $this->department_id = (string) $supervisor->department_id;
    }
}
