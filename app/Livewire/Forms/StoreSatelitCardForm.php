<?php

namespace App\Livewire\Forms;

use App\Models\SatelitCard;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreSatelitCardForm extends Form
{
    #[Validate('required', message: 'Vyplňte satelitní kartu')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:satelit_cards,name', message: 'Karta již existuje')]
    public string $name = '';

    #[Validate('required', message: 'Vyberte distributra')]
    public int|null $satelit_card_vendor_id = null;

    public function create(): mixed
    {
        $this->validate();

        $satCard = SatelitCard::create([
            'name' => $this->name,
            'satelit_card_vendor_id' => $this->satelit_card_vendor_id,
        ]);

        $this->reset('name', 'satelit_card_vendor_id');

        return $satCard;
    }
}
