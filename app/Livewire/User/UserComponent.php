<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\AvatarForm;
use App\Livewire\Forms\UserEditForm;
use Illuminate\Support\Facades\Auth;
use App\Events\BroadcastRefreshUserEvent;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Users\SessionUserAgentTrait;
use App\Livewire\Forms\ChangeUserPasswordForm;
use App\Traits\Users\CheckIfIsPinnedIptvWindowTrait;

class UserComponent extends Component
{
    use NotificationTrait, SessionUserAgentTrait, WithFileUploads, CheckIfIsPinnedIptvWindowTrait;

    public AvatarForm $avatarForm;

    public UserEditForm $userEditForm;

    public ChangeUserPasswordForm $changeUserPasswordForm;

    public User $user;

    public array $userSessions;

    public bool $avatarDialog = false;

    public bool $editUserDialog = false;

    public bool $isPinned = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->userSessions = $this->agents();
        $this->isPinned = $this->pinned($this->user->iptv_monitoring_window);
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

    public function pinIptvWindow()
    {
        $windowStatus = $this->convert_response_to_db_string($this->isPinned);

        $this->user->update([
            'iptv_monitoring_window' => $windowStatus
        ]);
        $this->redirect(url()->previous(), true);
        return $this->success_alert('Změna provedena');
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
