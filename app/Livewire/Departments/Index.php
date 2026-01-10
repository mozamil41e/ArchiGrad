<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;



class Index extends Component
{

    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    // Modal state
    public $showModal = false;
    public $isEditMode = false;
    public $confirmingDeletion = false;

    // Form data
    public $departmentId;
    public $name = '';
    public $description = '';

    protected $rules = [
        'name' => 'required|string|max:100|unique:departments,name',
    ];

    protected $messages = [
        'name.required' => 'اسم القسم مطلوب.',
        'name.unique' => 'هذا القسم موجود مسبقاً.',
        'name.max' => 'اسم القسم يجب ألا يتجاوز 100 حرف.',
    ];

    public function mount()
    {
        // تهيئة الخصائص من الـ request إذا كانت موجودة
        $this->search = request('search', $this->search);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'description', 'departmentId', 'isEditMode']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function edit(Department $department)
    {
        $this->resetValidation();
        $this->departmentId = $department->id;
        $this->name = $department->name;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validationRules = $this->rules;
        if ($this->isEditMode) {
            $validationRules['name'] = 'required|string|max:100|unique:departments,name,' . $this->departmentId;
        }

        $this->validate($validationRules);

        if ($this->isEditMode) {
            $department = $this->getDepartment($this->departmentId);
            $department->update([
                'name' => $this->name,
            ]);
            session()->flash('message', 'تم تحديث القسم بنجاح.');
        } else {
            Department::create([
                'name' => $this->name,
            ]);
            session()->flash('message', 'تم إضافة القسم بنجاح.');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->departmentId = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $this->getDepartment($this->departmentId)->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'تم حذف القسم بنجاح.');
    }

    public function getDepartment($id)
    {
        return Department::find($id);
    }


    public function render()
    {
        $departments = Department::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount([
                'supervisors',
                'projects',
                'students',
            ])
            ->orderBy('name')
            ->paginate(6);

        return view('livewire.departments.index', compact('departments'));
    }
}
