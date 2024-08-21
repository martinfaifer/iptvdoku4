<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVchannelsTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsGeniusTvChannelsTaxesForm extends Form
{
    public ?GeniusTVchannelsTax $channelTax;

    public string|int $channel_id = '';

    #[Validate('required', message: 'Vyplňte cenu')]
    #[Validate('string', message: 'Neplatný formát')]
    public string|float $price = '0';

    #[Validate('required', message: 'Vyberte měnu')]
    public mixed $currency = null;

    public function setChannelTax(GeniusTVchannelsTax $channelTax): void
    {
        $this->channelTax = $channelTax;
        $this->channel_id = $channelTax->channel_id;
        $this->price = $channelTax->price;
        $this->currency = $channelTax->currency;
    }

    public function update(): void
    {
        $this->channelTax->update([
            'price' => $this->price,
            'currency' => $this->currency,
        ]);

        $this->reset();
    }
}
