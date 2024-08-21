<?php

namespace App\Livewire\User;

use App\Livewire\Forms\UserNotificationForm;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserNotificationComponent extends Component
{
    use NotificationTrait;

    public UserNotificationForm $form;

    public function mount(): void
    {
        $this->edit();
    }

    public function edit(): void
    {
        $this->form->setNotifications(Auth::user());
    }

    public function update(): mixed
    {
        $this->form->update();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.user.user-notification-component');
    }
}
