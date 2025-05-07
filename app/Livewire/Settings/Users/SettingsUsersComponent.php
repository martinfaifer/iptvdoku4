<?php

namespace App\Livewire\Settings\Users;

use App\Livewire\Forms\CreateSettingsUserForm;
use App\Livewire\Forms\UpdateSettingsUserForm;
use App\Mail\SendForgottenPasswordMail;
use App\Models\User;
use App\Models\UserRole;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Users\GeneratePasswordTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsUsersComponent extends Component
{
    use GeneratePasswordTrait, NotificationTrait, WithPagination;

    public CreateSettingsUserForm $form;

    public UpdateSettingsUserForm $editForm;

    public bool $createModal = false;

    public bool $editModal = false;

    public string $query = '';

    public Collection $userRoles;

    public function mount(): void
    {
        $this->userRoles = UserRole::get(['id', 'name']);
    }

    public function openCreateModal(): void
    {
        $this->resetErrorBag();

        $this->createModal = true;
    }

    public function closeDialog(): void
    {
        $this->editModal = false;
        $this->createModal = false;
    }

    public function create(): mixed
    {
        $this->form->create();
        $this->closeDialog();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Uživatel vytvořen');
    }

    public function edit(User $user): mixed
    {
        $this->editForm->setUser($user);

        return $this->editModal = true;
    }

    public function update(): mixed
    {
        $this->editForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Uživatel upraven');
    }

    public function resetPassword(User $user): mixed
    {
        $password = $this->generate_password();
        $user->update([
            'password' => $password,
        ]);

        Mail::to($user->email)->queue(new SendForgottenPasswordMail($password));

        return $this->success_alert('Odeslán email s novým heslem');
    }

    public function destroy(User $user): mixed
    {
        $user->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Uživatel odebrán');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.users.settings-users-component', [
            'users' => User::search($this->query)->with('userRole')->paginate(),
            'headers' => [
                ['key' => 'avatar', 'label' => ''],
                ['key' => 'first_name', 'label' => 'Jméno', 'class' => 'dark:text-white/80'],
                ['key' => 'last_name', 'label' => 'Příjmení', 'class' => 'dark:text-white/80'],
                ['key' => 'email', 'label' => 'Email', 'class' => 'dark:text-white/80'],
                ['key' => 'userRole.name', 'label' => 'Role', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
