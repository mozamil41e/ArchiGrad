<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class DeleteModal extends Component
{
    public bool $confirmingDeletion = false;
    public ?int $deletingId = null;
    public string $title = 'تأكيد الحذف';
    public string $message = 'هل أنت متأكد من حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء.';

    protected $listeners = ['confirmDelete' => 'confirm'];

    public function confirm(int $id, string $title = '', string $message = ''): void
    {
        $this->deletingId = $id;
        $this->title = $title ?: 'تأكيد الحذف';
        $this->message = $message ?: 'هل أنت متأكد من حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء.';
        $this->confirmingDeletion = true;
    }

    public function delete(): void
    {
        $this->dispatch('deleteConfirmed', id: $this->deletingId);
        $this->reset(['confirmingDeletion', 'deletingId']);
    }

    public function cancel(): void
    {
        $this->reset(['confirmingDeletion', 'deletingId']);
    }

    public function render()
    {
        return view('livewire.shared.delete-modal');
    }
}
