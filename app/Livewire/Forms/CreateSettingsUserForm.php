<?php

namespace App\Livewire\Forms;

use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use App\Traits\Users\GeneratePasswordTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsUserForm extends Form
{
    use GeneratePasswordTrait;

    #[Validate('required', message: 'Vyplňte jméno')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $first_name = '';

    #[Validate('required', message: 'Vyplňte příjmení')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $last_name = '';

    #[Validate('required', message: 'Vyplňte email')]
    #[Validate('email', message: 'Neplatný formát')]
    #[Validate('unique:users,email', message: 'Tento email již existuje')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $email = '';

    #[Validate('required', message: 'Vyberte roli')]
    #[Validate('exists:user_roles,id', message: 'Neexistující role')]
    public string $userRoleId = '';

    public function create(): mixed
    {
        $this->validate();

        $password = $this->generate_password();

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $password,
            'user_role_id' => $this->userRoleId,
            'iptv_monitoring_window' => 'closed',
        ]);

        $this->reset();

        // send welcome email via job
        SendWelcomeEmailJob::dispatch($user->email, $password);

        return $user;
    }
}
