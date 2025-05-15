<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LoginAction;
use App\Livewire\Forms\LoginForm;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    use NotificationTrait;

    public LoginForm $form;

    public function login(): void
    {
        $loginFormResponse = $this->form->submit();
        if ($loginFormResponse) {
            $this->success_alert('Přihlášeno');
            $this->redirect('/', navigate: true);
        } else {
            $this->error_alert('Neplatné údaje');
        }
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        if (Auth::user()) {
            $this->redirect('/', true);
        }

        return view('livewire.auth.login');
    }
}
