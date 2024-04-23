<?php

namespace App\Livewire\Forms;

use App\Models\SatelitCardVendor;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsDevicesDistributorsForm extends Form
{

    public ?SatelitCardVendor $satelitCardVendor;

    #[Validate('required', message: "Vyplňte distributora")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $name = "";


    public function setDistributor(SatelitCardVendor $satelitCardVendor)
    {
        $this->satelitCardVendor = $satelitCardVendor;
        $this->name = $satelitCardVendor->name;
    }

    public function update()
    {
        $this->validate();
        if ($this->name != $this->satelitCardVendor->name) {
            $this->satelitCardVendor->update([
                'name' => $this->name
            ]);
        }

        $this->reset();
    }
}
