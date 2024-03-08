<?php

namespace App\Livewire\Forms;

use App\Models\Contact;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateContact extends Form
{
    public ?Contact $contact;

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

    public function set_contact($contact)
    {
        $this->contact = $contact;
        $this->full_name = $contact->full_name;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
    }

    public function update()
    {
        $this->contact->update([
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->reset('contact', 'full_name', 'email', 'phone');
    }
}
