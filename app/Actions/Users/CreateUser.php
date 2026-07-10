<?php

namespace App\Actions\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function execute(UserForm $form): User
    {
        return User::create([
            'name' => $form->name,
            'email' => $form->email,
            'password' => Hash::make($form->password),
            'role' => $form->role,
        ]);
    }
}
