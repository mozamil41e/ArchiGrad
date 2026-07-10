<?php

namespace App\Actions\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUser
{
    public function execute(User $user, UserForm $form): User
    {
        $data = [
            'name' => $form->name,
            'email' => $form->email,
            'role' => $form->role,
        ];

        if ($form->password !== '') {
            $data['password'] = Hash::make($form->password);
        }

        $user->update($data);

        return $user;
    }
}
