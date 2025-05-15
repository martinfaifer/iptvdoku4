<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Actions\Auth\LoginAction;
use Livewire\Attributes\Validate;
use App\Traits\Livewire\NotificationTrait;

class LoginForm extends Form
{
    #[Validate('required', message: 'Vyplňte email')]
    #[Validate('max:255', message: 'Maximální délka je 255')]
    #[Validate('email', message: "Neplatný formát")]
    public string $email = '';

    #[Validate('required', message: 'Vyplňte heslo')]
    #[Validate('max:255', message: 'Maximální délka je 255')]
    public string $password = '';

    public function submit(): bool
    {
        $this->validate();

        if ((new LoginAction($this->email, $this->password))() == true) {
            return true;
        } else {
            $this->reset();
            return false;
        }
    }
}
