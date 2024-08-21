<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVchannelPackagesTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsGeniusTvChannelPackagesTaxesForm extends Form
{
    #[Validate('required', message: 'Vyberte kanály')]
    public array $channels_id = [];

    #[Validate('required', message: 'Vyplňte cenu')]
    #[Validate('string', message: 'Neplatný formát')]
    public string $price = '0';

    #[Validate('required', message: 'Vyberte měnu')]
    public int|float|null $currency = null;

    public function create(): void
    {
        $this->validate();

        GeniusTVchannelPackagesTax::create([
            'channels_id' => json_encode($this->channels_id),
            'price' => $this->price,
            'currency' => $this->currency,
        ]);

        $this->reset();
    }
}
