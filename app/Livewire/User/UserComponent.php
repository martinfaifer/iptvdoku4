<?php

namespace App\Livewire\User;

use App\Events\BroadcastRefreshUserEvent;
use App\Livewire\Forms\AvatarForm;
use App\Livewire\Forms\ChangeUserPasswordForm;
use App\Livewire\Forms\UserEditForm;
use App\Models\Session;
use App\Models\User;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Users\CheckIfIsPinnedIptvWindowTrait;
use App\Traits\Users\SessionUserAgentTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserComponent extends Component
{
    use CheckIfIsPinnedIptvWindowTrait, NotificationTrait, SessionUserAgentTrait, WithFileUploads;

    public AvatarForm $avatarForm;

    public UserEditForm $userEditForm;

    public ChangeUserPasswordForm $changeUserPasswordForm;

    public User $user;

    public array $userSessions;

    public bool $avatarDialog = false;

    public bool $editUserDialog = false;

    public bool $isPinned = false;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->userSessions = $this->agents();
        $this->isPinned = $this->pinned($this->user->iptv_monitoring_window);
    }

    public function openEditUserDialog(): void
    {
        $this->userEditForm->setUser(Auth::user());

        $this->editUserDialog = true;
    }

    public function openAvatarDialog(): void
    {
        $this->avatarDialog = true;
    }

    public function upload_avatar(): mixed
    {
        $this->avatarForm->upload_avatar();
        $this->redirect(url()->previous(), true);
        BroadcastRefreshUserEvent::dispatch();

        return $this->success_alert('Avatar nahrán');
    }

    public function deleteAvatar(): mixed
    {
        $this->avatarForm->delete_avatar();
        $this->redirect(url()->previous());
        BroadcastRefreshUserEvent::dispatch();

        return $this->success_alert('Avatar odebrán');
    }

    public function update(): mixed
    {
        $this->userEditForm->update();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function session_destroy(Session $session): mixed
    {
        $session->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function sessions_destroy(): mixed
    {
        Session::forUser($this->user->id)->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function changePassword(): mixed
    {
        $this->changeUserPasswordForm->update();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Heslo změněno');
    }

    public function pinIptvWindow(): mixed
    {
        $windowStatus = $this->convert_response_to_db_string($this->isPinned);

        $this->user->update([
            'iptv_monitoring_window' => $windowStatus,
        ]);
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Změna provedena');
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();
        $this->editUserDialog = false;
        $this->userEditForm->reset();
        $this->avatarDialog = false;
        $this->avatarForm->reset();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.user.user-component');
    }
}
