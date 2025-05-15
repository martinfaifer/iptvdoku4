<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\ForgottenPasswordForm;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class ForgottenPasswordComponent extends Component
{
    use NotificationTrait;

    public ForgottenPasswordForm $form;

    public function sendPassword(): mixed
    {
        $this->form->submit();
        $this->redirect('login', true);

        return $this->success_alert('Odeslán email s novým heslem');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.auth.forgotten-password-component');
    }
}
