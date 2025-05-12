<?php

namespace App\Livewire\Forms;

use App\Models\DeviceTemplateGpu;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsDeviceGpuModulTemplateForm extends Form
{
    #[Validate('required', message: "Vyplňte model")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    #[Validate('unique:device_template_gpus,name', message: "Toto gpu již existuje")]
    public string $name = "";

    #[Validate('required', "Vyplňte počet streamů")]
    #[Validate('numeric', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximáln počet znaků je :max")]
    public int $max_streams = 0;

    public function submit()
    {
        $validated = $this->validate();

        DeviceTemplateGpu::create([
            'name' => $validated['name'],
            'max_streams' => $validated['max_streams']
        ]);
    }
}
