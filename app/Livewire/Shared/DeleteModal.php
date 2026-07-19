<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class DeleteModal extends Component
{
    public bool $confirmingDeletion = false;
    public ?int $deletingId = null;
    public string $modelClass = '';
    public string $title = 'تأكيد الحذف';
    public string $message = 'هل أنت متأكد من حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء.';
    public string $successMessage = 'تم الحذف بنجاح.';

    protected $listeners = ['confirmDelete' => 'confirm'];

    public function confirm(int $id, string $modelClass, string $title = '', string $message = '', string $successMessage = ''): void
    {
        $this->deletingId = $id;
        $this->modelClass = $modelClass;
        $this->title = $title ?: 'تأكيد الحذف';
        $this->message = $message ?: 'هل أنت متأكد من حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء.';
        $this->successMessage = $successMessage ?: 'تم الحذف بنجاح.';
        $this->confirmingDeletion = true;
    }

    public function delete(): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        // $model = ($this->modelClass)::findOrFail($this->deletingId);
        // $model->delete();

        $successMessage = $this->successMessage;
        $this->reset(['confirmingDeletion', 'deletingId', 'modelClass', 'successMessage']);
        $this->dispatch('itemDeleted', message: $successMessage , modelClass: $this->modelClass);
    }

    public function cancel(): void
    {
        $this->reset(['confirmingDeletion', 'deletingId', 'modelClass']);
    }

    public function render()
    {
        return view('livewire.shared.delete-modal');
    }
}
