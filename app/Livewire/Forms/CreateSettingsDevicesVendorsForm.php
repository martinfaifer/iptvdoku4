<?php

namespace App\Livewire\Forms;

use App\Models\DeviceVendor;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsDevicesVendorsForm extends Form
{
    #[Validate('required', message: "Vyplňte výrobce")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', "Maximální počet znaků je :max")]
    #[Validate('unique:device_vendors,name', message: "tento výrobce již existuje")]
    public string $name = "";

    public function create()
    {
        $this->validate();

        DeviceVendor::create([
            'name' => $this->name
        ]);

        $this->reset();
    }
}
