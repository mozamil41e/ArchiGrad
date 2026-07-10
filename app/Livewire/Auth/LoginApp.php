<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\AuthenticateUser;
use Livewire\Component;
use Livewire\Attributes\Validate;

class LoginApp extends Component
{
    #[Validate('required|email', message: [
        'required' => 'البريد الإلكتروني مطلوب',
        'email' => 'البريد الإلكتروني غير صالح',
    ])]
    public string $email = '';

    #[Validate('required|min:6', message: [
        'required' => 'كلمة المرور مطلوبة',
        'min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
    ])]
    public string $password = '';

    public bool $rememberMe = false;

    public function submitForm(AuthenticateUser $authenticateUser)
    {
        $this->validate();

        $authenticateUser->execute($this->email, $this->password, $this->rememberMe);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login-app');
    }
}
