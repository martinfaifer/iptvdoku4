<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\UserNotificationForm;

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
