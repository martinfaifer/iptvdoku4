<?php

namespace App\Livewire\Settings\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsUserForm;
use App\Livewire\Forms\UpdateSettingsUserForm;

class SettingsUsersComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsUserForm $form;
    public UpdateSettingsUserForm $editForm;

    public bool $createModal = false;
    public bool $editModal = false;

    public $query = '';

    public function openCreateModal()
    {
        $this->resetErrorBag();

        return $this->createModal = true;
    }

    public function closeDialog()
    {
        return $this->editModal = false;
        return $this->createModal = false;
    }

    public function create()
    {
        $this->form->create();
        $this->closeDialog();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Uživatel vytvořen');
    }

    public function edit(User $user)
    {
        $this->editForm->setUser($user);
        return $this->editModal = true;
    }

    public function update()
    {
        $this->editForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Uživatel upraven');
    }

    public function destroy(User $user)
    {
        $user->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Uživatel odebrán');
    }

    public function render()
    {
        return view('livewire.settings.users.settings-users-component', [
            'users' => User::search($this->query)->paginate(),
            'headers' => [
                ['key' => 'first_name', 'label' => 'Jméno', 'class' => 'text-white/80'],
                ['key' => 'last_name', 'label' => 'Příjmení', 'class' => 'text-white/80'],
                ['key' => 'email', 'label' => 'Email', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
