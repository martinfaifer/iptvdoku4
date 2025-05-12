<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\DeviceTemplateGpu;

class UpdateSettingsDeviceGpuModulTemplateForm extends Form
{
    public $deviceTemplateGpu;
    public int $id = 0;
    public string $name = "";
    public int $max_streams = 0;

    public function setDeviceTemplateGpu(DeviceTemplateGpu $deviceTemplateGpu)
    {
        $this->$deviceTemplateGpu = $deviceTemplateGpu;
        $this->id = $deviceTemplateGpu->id;
        $this->name = $deviceTemplateGpu->name;
        $this->max_streams = $deviceTemplateGpu->max_streams;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:device_template_gpus,name,' . $this->id
            ],
            'max_streams' => [
                'required',
                'numeric',
                'max:255'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vyplňte model",
            'name.string' => "Neplatný formát",
            'name.max' => "Maximální počet znaků je :max",
            'name.unique' => "Toto GPU již existuje",
            'max_streams.required' => "Vyplňte počet streamů",
            'max_streams.numeric' => "Neplatný formát",
            'max_streams.max' => "Maximální počet streamů je :max"
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        DeviceTemplateGpu::find($this->id)->update([
            'name' => $validated['name'],
            'max_streams' => $validated['max_streams']
        ]);
    }
}
