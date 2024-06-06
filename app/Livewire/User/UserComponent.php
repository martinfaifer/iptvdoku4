<?php

namespace App\Livewire\User;

use App\Events\BroadcastRefreshUserEvent;
use App\Livewire\Forms\AvatarForm;
use App\Livewire\Forms\ChangeUserPasswordForm;
use App\Livewire\Forms\UserEditForm;
use App\Models\Session;
use App\Models\User;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Users\SessionUserAgentTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserComponent extends Component
{
    use NotificationTrait, SessionUserAgentTrait, WithFileUploads;

    public AvatarForm $avatarForm;

    public UserEditForm $userEditForm;

    public ChangeUserPasswordForm $changeUserPasswordForm;

    public User $user;

    public array $userSessions;

    public bool $avatarDialog = false;

    public bool $editUserDialog = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->userSessions = $this->agents();
    }

    public function openEditUserDialog()
    {
        $this->userEditForm->setUser(Auth::user());

        return $this->editUserDialog = true;
    }

    public function openAvatarDialog()
    {
        $this->avatarDialog = true;
    }

    public function upload_avatar()
    {
        $this->avatarForm->upload_avatar();
        $this->redirect(url()->previous(), true);
        BroadcastRefreshUserEvent::dispatch();

        return $this->success_alert('Avatar nahrán');
    }

    public function deleteAvatar()
    {
        $this->avatarForm->delete_avatar();
        $this->redirect(url()->previous());
        BroadcastRefreshUserEvent::dispatch();

        return $this->success_alert('Avatar odebrán');
    }

    public function update()
    {
        $this->userEditForm->update();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function session_destroy(Session $session)
    {
        $session->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function sessions_destroy()
    {
        Session::forUser($this->user->id)->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function changePassword()
    {
        $this->changeUserPasswordForm->update();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Heslo změněno');
    }

    public function closeDialog()
    {
        $this->resetErrorBag();
        $this->editUserDialog = false;
        $this->userEditForm->reset();
        $this->avatarDialog = false;
        $this->avatarForm->reset();
    }

    public function render()
    {
        return view('livewire.user.user-component');
    }
}
