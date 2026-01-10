<?php

namespace App\Livewire\Supervisors;

use App\Models\Department;
use App\Models\Supervisor;
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
    public $supervisorId;
    public $name = '';
    public $department_id = '';

    protected $rules = [
        'name' => 'required|string|max:100|unique:supervisors,name',
        'department_id' => 'required|exists:departments,id',
    ];

    protected $messages = [
        'name.required' => 'اسم المشرف مطلوب.',
        'name.unique' => 'هذا المشرف موجود مسبقاً.',
        'name.max' => 'اسم المشرف يجب ألا يتجاوز 100 حرف.',
        'department_id.required' => 'القسم مطلوب.',
        'department_id.exists' => 'القسم غير موجود.',
    ];

    public function mount()
    {
        // تهيئة الخصائص من الـ request إذا كانت موجودة
        $this->search = request('search', $this->search);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'department_id', 'supervisorId', 'isEditMode']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function edit(Supervisor $supervisor)
    {
        $this->resetValidation();
        $this->supervisorId = $supervisor->id;
        $this->name = $supervisor->name;
        $this->department_id = $supervisor->department_id;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validationRules = $this->rules;
        if ($this->isEditMode) {
            $validationRules['name'] = 'required|string|max:100|unique:supervisors,name,' . $this->supervisorId;
        }

        $this->validate($validationRules);

        if ($this->isEditMode) {
            $supervisor = $this->getSupervisor($this->supervisorId);
            $supervisor->update([
                'name' => $this->name,
                'department_id' => $this->department_id,
            ]);
            session()->flash('message', 'تم تحديث المشرف بنجاح.');
        } else {
            Supervisor::create([
                'name' => $this->name,
                'department_id' => $this->department_id,
            ]);
            session()->flash('message', 'تم إضافة المشرف بنجاح.');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->supervisorId = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $this->getSupervisor($this->supervisorId)->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'تم حذف المشرف بنجاح.');
    }

    public function getSupervisor($id)
    {
        return Supervisor::find($id);
    }


    public function render()
    {
        $supervisors = Supervisor::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount([
                'projects',
            ])
            ->orderBy('name')
            ->paginate(3);
        $departments = Department::select('id', 'name')->get();
        return view('livewire.supervisors.index', compact('supervisors', 'departments'));
    }
}
