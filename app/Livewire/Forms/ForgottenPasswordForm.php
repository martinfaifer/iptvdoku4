<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendForgottenPasswordMail;
use App\Traits\Users\GeneratePasswordTrait;

class ForgottenPasswordForm extends Form
{
    use GeneratePasswordTrait;

    #[Validate('required', message: "Vyplňte email")]
    #[Validate('email', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je 255')]
    #[Validate('exists:users,email', message: 'Neexistující email')]
    public string $email = '';

    public function submit()
    {
        $this->validate();
        $password = $this->generate_password();

        User::where('email', $this->email)->update([
            'password' => bcrypt($password),
        ]);

        Mail::to($this->email)->queue(new SendForgottenPasswordMail($password));
    }
}
