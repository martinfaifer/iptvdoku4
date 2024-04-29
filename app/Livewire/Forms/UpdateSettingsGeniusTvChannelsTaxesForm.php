<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVchannelsTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsGeniusTvChannelsTaxesForm extends Form
{
    public ?GeniusTVchannelsTax $channelTax;

    public string $channel_id = '';

    #[Validate('required', message: 'Vyplňte cenu')]
    #[Validate('string', message: 'Neplatný formát')]
    public string $price = '0';

    #[Validate('required', message: 'Vyberte měnu')]
    public $currency = null;

    public function setChannelTax(GeniusTVchannelsTax $channelTax)
    {
        $this->channelTax = $channelTax;
        $this->channel_id = $channelTax->channel_id;
        $this->price = $channelTax->price;
        $this->currency = $channelTax->currency;
    }

    public function update()
    {
        $this->channelTax->update([
            'price' => $this->price,
            'currency' => $this->currency,
        ]);

        $this->reset();
    }
}
