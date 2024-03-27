<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTVStaticTax;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsGeniusTvStaticTaxesForm extends Form
{
    #[Validate('required', message: "Vyplňte název")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    #[Validate('unique:genius_t_v_static_taxes,name', message: "Toto již existuje")]
    public string $name = "";

    #[Validate('required', message: "Vyplňte cenu")]
    #[Validate('string', message: "Neplatný formát")]
    public string $price = "0";

    #[Validate('required', message: "Vyberte měnu")]
    public $currency = null;

    public function create()
    {
        $this->validate();

        GeniusTVStaticTax::create([
            'name' => $this->name,
            'price' => (float) $this->price,
            'currency' => $this->currency
        ]);

        $this->reset();
    }
}
