<?php

namespace App\Livewire\Forms;

use App\Models\SatelitCard;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSatelitCardExpirationForm extends Form
{
    #[Validate('required', message: "Vyplňte expiraci")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počt znaků je :max")]
    public string $expiration = "";

    public function create(SatelitCard $satelitCard)
    {
        $this->validate();

        $satelitCard->update([
            'expiration' => $this->expiration
        ]);

        $this->reset();
    }
}
