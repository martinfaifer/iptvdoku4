<?php

namespace App\Livewire\Forms;

use App\Models\SatelitCard;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSatelitCardExpirationForm extends Form
{
    public ?SatelitCard $satelitCard;

    #[Validate('required', message: 'Vyplňte expiraci')]
    #[Validate('string', message: 'neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet zanků je :max')]
    public string $expiration = '';

    public function setSatelitCard(SatelitCard $satelitCard)
    {
        $this->satelitCard = $satelitCard;
        $this->expiration = $satelitCard->expiration;
    }

    public function update()
    {
        $this->validate();

        $this->satelitCard->update([
            'expiration' => $this->expiration,
        ]);

        $this->reset();
    }
}
