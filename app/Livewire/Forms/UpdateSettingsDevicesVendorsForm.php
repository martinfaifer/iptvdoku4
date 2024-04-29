<?php

namespace App\Livewire\Forms;

use App\Models\DeviceVendor;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsDevicesVendorsForm extends Form
{
    public ?DeviceVendor $deviceVendor;

    #[Validate('required', message: 'Vyplňte výrobce')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', 'Maximální počet znaků je :max')]
    public string $name = '';

    public function setVendor(DeviceVendor $deviceVendor)
    {
        $this->deviceVendor = $deviceVendor;

        $this->name = $deviceVendor->name;
    }

    public function update()
    {
        $this->validate();

        if ($this->name != $this->deviceVendor->name) {
            $this->deviceVendor->update([
                'name' => $this->name,
            ]);
        }

        $this->reset();
    }
}
