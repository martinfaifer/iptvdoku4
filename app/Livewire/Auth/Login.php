<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LoginAction;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    use NotificationTrait;

    #[Validate('required', message: 'Vyplňte email')]
    public string $email = '';

    #[Validate('required', message: 'Vyplňte heslo')]
    public string $password = '';

    public function login()
    {
        $this->validate();

        if ((new LoginAction($this->email, $this->password))() == true) {
            $this->success_alert('Přihlášeno');

            return $this->redirect('/', navigate: true);
        }
        $this->error_alert('Neplatné údaje');
        $this->reset();
    }

    public function render()
    {
        if (Auth::user()) {
            $this->redirect('/');
        }

        return view('livewire.auth.login');
    }
}