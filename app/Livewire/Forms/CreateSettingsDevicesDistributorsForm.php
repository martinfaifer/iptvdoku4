<?php

namespace App\Livewire\Forms;

use App\Models\SatelitCardVendor;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsDevicesDistributorsForm extends Form
{
    #[Validate('required', message: "Vyplňte distributora")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    #[Validate('unique:satelit_card_vendors,name', message: "Tento distributor již existuje")]
    public string $name = "";

    public function create()
    {
        $this->validate();

        SatelitCardVendor::create([
            'name' => $this->name
        ]);

        $this->reset();
    }
}
