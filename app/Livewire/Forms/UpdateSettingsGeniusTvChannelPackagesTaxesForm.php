<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVchannelPackagesTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsGeniusTvChannelPackagesTaxesForm extends Form
{
    public ?GeniusTVchannelPackagesTax $channelPackageTax;

    #[Validate('required', message: 'Vyberte kanály')]
    public array $channels_id = [];

    #[Validate('required', message: 'Vyplňte cenu')]
    #[Validate('string', message: 'Neplatný formát')]
    public string $price = '0';

    #[Validate('required', message: 'Vyberte měnu')]
    public $currency = null;

    #[Validate('nullable')]
    public array $exception = [];

    #[Validate('required', message: 'Rozhodněte se zda mají být obsaženy všechny kanály')]
    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $must_contains_all = false;

    public function setChannelPackageTax(GeniusTVchannelPackagesTax $channelPackageTax)
    {
        $this->channelPackageTax = $channelPackageTax;
        $this->channels_id = json_decode($channelPackageTax->channels_id);
        $this->price = $channelPackageTax->price;
        $this->currency = $channelPackageTax->currency;
        $this->exception = blank($channelPackageTax->exception) ? [] : json_decode($channelPackageTax->exception);
        $this->must_contains_all = $channelPackageTax->must_contains_all;
    }

    public function update()
    {
        $this->validate();

        $this->channelPackageTax->update([
            'channels_id' => json_encode($this->channels_id),
            'price' => $this->price,
            'currency' => $this->currency,
            'exception' => empty($this->exception) ? null : json_encode($this->exception),
            'must_contains_all' => $this->must_contains_all,
        ]);

        $this->reset();
    }
}
