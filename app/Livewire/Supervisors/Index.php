<?php

namespace App\Livewire\Supervisors;

use App\Actions\Supervisors\CreateSupervisor;
use App\Actions\Supervisors\DeleteSupervisor;
use App\Actions\Supervisors\UpdateSupervisor;
use App\Livewire\Forms\SupervisorForm;
use App\Models\Department;
use App\Models\Supervisor;
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

    public SupervisorForm $form;
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

    public function edit(Supervisor $supervisor): void
    {
        $this->resetValidation();
        $this->form->fromSupervisor($supervisor);
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function save(CreateSupervisor $createSupervisor, UpdateSupervisor $updateSupervisor): void
    {
        $this->form->validate();

        if ($this->isEditMode) {
            $updateSupervisor->execute(Supervisor::findOrFail($this->form->supervisorId), $this->form);
            session()->flash('message', 'تم تحديث المشرف بنجاح.');
        } else {
            $createSupervisor->execute($this->form);
            session()->flash('message', 'تم إضافة المشرف بنجاح.');
        }

        $this->closeModal();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->confirmingDeletion = true;
    }

    public function delete(DeleteSupervisor $deleteSupervisor): void
    {
        $deleteSupervisor->execute(Supervisor::findOrFail($this->deletingId));
        $this->confirmingDeletion = false;
        session()->flash('message', 'تم حذف المشرف بنجاح.');
    }

    public function render()
    {
        $supervisors = Supervisor::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount(['projects'])
            ->orderBy('name')
            ->paginate(6);

        $departments = Department::select('id', 'name')->get();

        return view('livewire.supervisors.index', compact('supervisors', 'departments'));
    }
}
