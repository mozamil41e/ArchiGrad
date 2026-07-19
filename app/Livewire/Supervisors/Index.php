<?php

namespace App\Livewire\Supervisors;

use App\Actions\Supervisors\CreateSupervisor;
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

    public SupervisorForm $form;

    protected $listeners = ['itemDeleted' => 'handleItemDeleted'];

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

    public function handleItemDeleted(string $message): void
    {
        session()->flash('message', $message);
    }

    public function confirmDelete(int $id): void
    {
        $this->dispatch('confirmDelete',
            id: $id,
            modelClass: Supervisor::class,
            title: 'حذف المشرف',
            message: 'هل أنت متأكد من حذف هذا المشرف؟ لا يمكن التراجع عن هذا الإجراء وسيتم حذف كافة البيانات المرتبطة.',
            successMessage: 'تم حذف المشرف بنجاح.',
        );
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
