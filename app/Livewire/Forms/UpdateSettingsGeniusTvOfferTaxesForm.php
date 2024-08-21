<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVChannelsOffersTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsGeniusTvOfferTaxesForm extends Form
{
    public ?GeniusTVChannelsOffersTax $offerTax;

    public string $offer = '';

    #[Validate('required', message: 'Vyberte kanály')]
    public array $channels_id = [];

    #[Validate('required', message: 'Vyplňte cenu')]
    #[Validate('string', message: 'Neplatný formát')]
    public string|float $price = '0';

    #[Validate('required', message: 'Vyberte měnu')]
    public mixed $currency = null;

    public function setOfferTax(GeniusTVChannelsOffersTax $offerTax): void
    {
        $this->offerTax = $offerTax;
        $this->offer = $offerTax->offer;
        $this->channels_id = json_decode($offerTax->channels_id);
        $this->price = $offerTax->price;
        $this->currency = $offerTax->currency;
    }

    public function update(): void
    {
        $this->validate();

        $this->offerTax->update([
            'channels_id' => json_encode($this->channels_id),
            'price' => $this->price,
            'currency' => $this->currency,
        ]);

        $this->reset();
    }
}
