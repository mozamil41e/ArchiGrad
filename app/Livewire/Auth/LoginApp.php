<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginApp extends Component
{
    #[Validate('required|email', message: [
        'required' => 'البريد الإلكتروني مطلوب',
        'email' => 'البريد الإلكتروني غير صالح',
    ])]
    public string $email = '';

    #[Validate('required|min:6', message: [
        'required' => 'كلمة المرور مطلوبة',
        'min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
    ])]
    public string $password = '';

    public bool $rememberMe = false;

    public function submitForm()
    {
        $this->validate();

        if (Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->rememberMe
        )) {
            session()->regenerate();
            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => 'بيانات الدخول غير صحيحة',
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login-app');
    }
}
