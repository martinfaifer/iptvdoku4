<?php

namespace App\Livewire\Forms;

use App\Models\SatelitCard;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSatelitCardForm extends Form
{
    public ?SatelitCard $satelitCard;

    public string $name = '';

    #[Validate('required', message: 'Vyberte distributra')]
    public $satelit_card_vendor_id;

    public function set_satelit_card(SatelitCard $satelitCard)
    {
        $this->satelitCard = $satelitCard;
        $this->name = $satelitCard->name;
        $this->satelit_card_vendor_id = $satelitCard->satelit_card_vendor_id;
    }

    public function update(): void
    {
        $this->validate();

        $this->satelitCard->update([
            'satelit_card_vendor_id' => $this->satelit_card_vendor_id,
        ]);

        $this->reset();
    }
}
