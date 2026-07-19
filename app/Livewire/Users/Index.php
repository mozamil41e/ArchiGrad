<?php

namespace App\Livewire\Users;

use App\Actions\Users\CreateUser;
use App\Actions\Users\DeleteUser;
use App\Actions\Users\UpdateUser;
use App\Enums\Role;
use App\Exceptions\UserDeletionException;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(history: true)]
    public $search = '';

    public bool $showModal = false;
    public bool $isEditMode = false;

    public UserForm $form;

    protected $listeners = ['itemDeleted' => 'handleItemDeleted'];

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    public function openModal(): void
    {
        $this->authorize('create', User::class);

        $this->resetValidation();
        $this->form->reset();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function edit(User $user): void
    {
        $this->authorize('update', User::class);

        $this->resetValidation();
        $this->form->fromUser($user);
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function save(CreateUser $createUser, UpdateUser $updateUser): void
    {
        $this->authorize($this->isEditMode ? 'update' : 'create', User::class);

        $this->form->validate();

        if ($this->isEditMode) {
            $updateUser->execute(User::findOrFail($this->form->userId), $this->form);
            session()->flash('message', 'تم تحديث المستخدم بنجاح.');
        } else {
            $createUser->execute($this->form);
            session()->flash('message', 'تم إضافة المستخدم بنجاح.');
        }

        $this->closeModal();
    }

    public function handleItemDeleted(string $message): void
    {
        session()->flash('message', $message);
    }

    public function confirmDelete(int $id): void
    {
        $this->authorize('delete', User::class);
        $this->dispatch('confirmDelete',
            id: $id,
            modelClass: User::class,
            title: 'حذف المستخدم',
            message: 'هل أنت متأكد من حذف هذا المستخدم؟ لا يمكن التراجع عن هذا الإجراء.',
            successMessage: 'تم حذف المستخدم بنجاح.',
        );
    }

    // public function delete(DeleteUser $deleteUser): void
    // {
    //     $this->authorize('delete', User::class);
    //     try {
    //         $deleteUser->execute(User::findOrFail($this->deletingId), auth()->user());
    //     } catch (UserDeletionException $e) {
    //         session()->flash('error', $e->getMessage());
    //         $this->confirmingDeletion = false;
    //         return;
    //     }
    //     $this->confirmingDeletion = false;
    //     session()->flash('message', 'تم حذف المستخدم بنجاح.');
    // }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn ($query) => $query->where(
                fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
            ))
            ->orderBy('name')
            ->paginate(6);

        return view('livewire.users.index', [
            'users' => $users,
            'roles' => Role::cases(),
        ]);
    }
}
