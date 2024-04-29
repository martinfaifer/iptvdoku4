<?php

namespace App\Livewire\Settings\Users;

use App\Livewire\Forms\CreateSettingsUserForm;
use App\Models\User;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsUsersComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsUserForm $form;

    public bool $createModal = false;

    public $query = '';

    public function openCreateModal()
    {
        $this->resetErrorBag();

        return $this->createModal = true;
    }

    public function closeModal()
    {
        return $this->createModal = false;
    }

    public function create()
    {
        $this->form->create();
        $this->closeModal();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Uživatel vytvořen');
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
