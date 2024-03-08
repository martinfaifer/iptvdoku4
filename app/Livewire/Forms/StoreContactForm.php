<?php

namespace App\Livewire\Forms;

use App\Models\Contact;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreContactForm extends Form
{
    #[Validate('required', message: 'Vyplňte kontaktní osobu / společnost')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $full_name = '';

    #[Validate('nullable')]
    #[Validate('email', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $email = '';

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $phone = '';

    public function create(string $type, int $item_id)
    {
        $this->validate();

        Contact::create([
            'type' => $type,
            'item_id' => $item_id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->reset('full_name', 'email', 'phone');
    }
}
