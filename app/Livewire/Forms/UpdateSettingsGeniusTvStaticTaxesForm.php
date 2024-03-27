<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\GeniusTVStaticTax;
use Livewire\Attributes\Validate;

class UpdateSettingsGeniusTvStaticTaxesForm extends Form
{

    public ?GeniusTVStaticTax $staticTax;

    public string $name = "";

    #[Validate('required', message: "Vyplňte cenu")]
    #[Validate('string', message: "Neplatný formát")]
    public string $price = "0";

    #[Validate('required', message: "Vyberte měnu")]
    public $currency = null;

    public function setStaticTax(GeniusTVStaticTax $staticTax)
    {
        $this->staticTax = $staticTax;
        $this->name = $staticTax->name;
        $this->price = $staticTax->price;
        $this->currency = $staticTax->currency;
    }

    public function update()
    {
        $this->validate();

        $this->staticTax->update([
            // 'name' => $this->name,
            'price' => $this->price,
            'currency' => $this->currency
        ]);

        $this->reset();
    }
}
