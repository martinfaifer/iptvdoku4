<?php

namespace App\Livewire\User;

use App\Livewire\Forms\UserNotificationForm;
use App\Models\User;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserNotificationComponent extends Component
{
    use NotificationTrait;

    public UserNotificationForm $form;

    public function mount()
    {
        $this->edit();
    }

    public function edit()
    {
        return $this->form->setNotifications(Auth::user());
    }

    public function update()
    {
        $this->form->update();
        $this->redirect(url()->previous(),true);

        return $this->success_alert("Upraveno");
    }

    public function render()
    {
        return view('livewire.user.user-notification-component');
    }
}
