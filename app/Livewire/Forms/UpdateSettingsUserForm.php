<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use Livewire\Attributes\Validate;

class UpdateSettingsUserForm extends Form
{

    public ?User $user;

    #[Validate('required', message: 'Vyplňte jméno')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $first_name = '';

    #[Validate('required', message: 'Vyplňte příjmení')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $last_name = '';

    #[Validate('required', message: "Vyberte roli")]
    #[Validate('exists:user_roles,id', message: "Neexistující role")]
    public string|null $userRoleId = "";

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->userRoleId = $user->user_role_id;
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_role_id' => $this->userRoleId
        ]);

        $this->reset();
    }
}
