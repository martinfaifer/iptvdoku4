<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\GeniusTVchannelPackagesTax;
use App\Traits\Channels\GeniusTVChannelPackagesTrait;

class CreateSettingsGeniusTvChannelPackagesTaxesForm extends Form
{
    use GeniusTVChannelPackagesTrait;

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

        $this->removeCachedGeniusTvChannelPackages();
        $this->reset();
    }
}
