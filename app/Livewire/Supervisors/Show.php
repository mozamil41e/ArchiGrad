<?php

namespace App\Livewire\Supervisors;

use App\Models\Supervisor;
use Livewire\Attributes\Title;
use Livewire\Component;


class Show extends Component
{
    #[Title('عرض المشرف')]

    public Supervisor $supervisor;

    public function mount(Supervisor $supervisor)
    {
        $this->supervisor = $supervisor->load(
            'department',
            'supervisor',
            'students'
        );
    }


    public function render()
    {
        $supervisor = $this->supervisor->with('projects');
        return view('livewire.supervisors.show', compact('supervisor'));
    }
}
