<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\View\Factory;
use App\Mail\SendForgottenPasswordMail;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Users\GeneratePasswordTrait;

class ForgottenPasswordComponent extends Component
{
    use GeneratePasswordTrait, NotificationTrait;

    #[Validate('email', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je 255')]
    #[Validate('exists:users,email', message: 'Neexistující email')]
    public string $email = '';

    public function sendNewPassword(): mixed
    {
        $this->validate();

        $password = $this->generate_password();

        User::where('email', $this->email)->update([
            'password' => bcrypt($password),
        ]);

        Mail::to($this->email)->queue(new SendForgottenPasswordMail($password));

        $this->redirect('login', true);

        return $this->success_alert('Odeslán email s novým heslem');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.auth.forgotten-password-component');
    }
}
