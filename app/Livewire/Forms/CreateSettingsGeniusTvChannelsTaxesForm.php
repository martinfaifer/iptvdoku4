<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVchannelsTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsGeniusTvChannelsTaxesForm extends Form
{
    #[Validate('required', message: 'Vyberte kanál')]
    #[Validate('exists:channels,id', message: 'Neznámý kanál')]
    #[Validate('unique:genius_t_vchannels_taxes,channel_id', message: 'Již existuje')]
    public string $channel_id = '';

    #[Validate('required', message: 'Vyplňte cenu')]
    #[Validate('string', message: 'Neplatný formát')]
    public string $price = '0';

    #[Validate('required', message: 'Vyberte měnu')]
    public $currency = null;

    public function create()
    {
        $this->validate();

        GeniusTVchannelsTax::create([
            'channel_id' => $this->channel_id,
            'price' => $this->price,
            'currency' => $this->currency,
        ]);

        $this->reset();
    }
}
