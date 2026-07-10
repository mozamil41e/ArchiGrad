<?php

namespace App\Livewire\Departments;

use App\Actions\Departments\CreateDepartment;
use App\Actions\Departments\DeleteDepartment;
use App\Actions\Departments\UpdateDepartment;
use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    public bool $showModal = false;
    public bool $isEditMode = false;
    public bool $confirmingDeletion = false;

    public DepartmentForm $form;
    public ?int $deletingId = null;

    public function openModal(): void
    {
        $this->resetValidation();
        $this->form->reset();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function edit(Department $department): void
    {
        $this->resetValidation();
        $this->form->fromDepartment($department);
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function save(CreateDepartment $createDepartment, UpdateDepartment $updateDepartment): void
    {
        $this->form->validate();

        if ($this->isEditMode) {
            $updateDepartment->execute(Department::findOrFail($this->form->departmentId), $this->form);
            session()->flash('message', 'تم تحديث القسم بنجاح.');
        } else {
            $createDepartment->execute($this->form);
            session()->flash('message', 'تم إضافة القسم بنجاح.');
        }

        $this->closeModal();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->confirmingDeletion = true;
    }

    public function delete(DeleteDepartment $deleteDepartment): void
    {
        $deleteDepartment->execute(Department::findOrFail($this->deletingId));
        $this->confirmingDeletion = false;
        session()->flash('message', 'تم حذف القسم بنجاح.');
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
                'projects as archived_projects_count' => function ($query) {
                    $query->where('is_archiv', true);
                },
                'projects as notarchived_projects_count' => function ($query) {
                    $query->where('is_archiv', false);
                },
                'students',
            ])
            ->orderBy('name')
            ->paginate(6);

        return view('livewire.departments.index', compact('departments'));
    }
}
