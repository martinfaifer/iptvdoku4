<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVChannelsOffersTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsGeniusTvOfferTaxesForm extends Form
{
    #[Validate('required', message: 'Vyplňte offer')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:genius_t_v_channels_offers_taxes,offer', message: 'tento offer je již zaveden')]
    public string $offer = '';

    #[Validate('required', message: 'Vyberte kanály')]
    public array $channels_id = [];

    #[Validate('required', message: 'Vyplňte cenu')]
    #[Validate('string', message: 'Neplatný formát')]
    public string $price = '0';

    #[Validate('required', message: 'Vyberte měnu')]
    public $currency = null;

    public function create()
    {
        $this->validate();

        GeniusTVChannelsOffersTax::create([
            'offer' => $this->offer,
            'channels_id' => json_encode($this->channels_id),
            'price' => $this->price,
            'currency' => $this->currency,
        ]);

        $this->reset();
    }
}
