<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserEditForm extends Form
{
    public ?User $user;

    #[Validate('required', message: 'Vyplňte jméno')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $first_name = '';

    #[Validate('required', message: 'Vyplňte přímení')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $last_name = '';

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);

        $this->reset();
    }
}
