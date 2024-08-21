<?php

namespace App\Livewire\Iptv\Devices;

use App\Engines\Devices\Templates\DeviceTemplateEngine;
use App\Models\Device;
use App\Models\DeviceTemplate;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class CreateDeviceTemplateComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public bool $storeDrawer = false;

    public mixed $availableTemplates;

    public int $numberOfInInterfaces = 0;

    public int $numberOfOutInterfaces = 0;

    public int $numberOfModules = 0;

    public ?string $inInterfaceName = '';

    public bool $hasInInterfaceFrequency = false;

    public bool $hasInInterfaceDvb = false;

    public bool $hasInInterfaceSatelite = false;

    public bool $hasInInterfacepolarization = false;

    public bool $hasInInterfacepolarizationVoltage = false;

    public bool $hasInInterfaceSymbolRate = false;

    public bool $hasInInterfaceFec = false;

    public bool $hasInInterfaceLnb = false;

    public bool $hasInInterfaceLnb22 = false;

    public bool $hasIntinterfaceSatCard = false;

    public bool $hasInInterfaceParabolaDiameter = false; // průměr anteny

    public bool $hasInInterfaceSatelit = false;

    public ?string $outInterfaceName = '';

    public bool $hasOutInterfaceInInterface = false;

    public bool $hasOutInterfaceSatCard = false;

    public bool $hasOutInterfaceLnb = false;

    public bool $hasOutInterfacefaceSatelit = false;

    public ?string $moduleName = '';

    public mixed $templateId;

    public function boot(): void
    {
        if (! $this->device->oids->isEmpty() && $this->device->showed_create_template == false) {
            $this->storeDrawer = true;
        }

        $this->availableTemplates = DeviceTemplate::get();
    }

    public function openModal(): void
    {
        $this->storeDrawer = true;
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();
        if ($this->device->showed_create_template == false) {
            $this->device->update([
                'showed_create_template' => true,
            ]);
        }

        $this->storeDrawer = false;
    }

    public function storePrebuildTemplateToDevice(): mixed
    {
        $template = DeviceTemplate::find($this->templateId);
        if (blank($template)) {
            $this->redirect('/devices/'.$this->device->id, true);

            return $this->error_alert('Šablona nenalezena');
        }
        $this->device->update([
            'template' => $template->template,  // @phpstan-ignore-line
        ]);

        $this->redirect('/devices/'.$this->device->id, true);

        return $this->success_alert('Přidána šablona');
    }

    public function store(): mixed
    {
        $engineResponse = (new DeviceTemplateEngine())->generate(
            device: $this->device,
            inputs: [
                'numberOfInInterfaces' => $this->numberOfInInterfaces,
                'inInterfaceName' => $this->inInterfaceName,
                'hasInInterfaceFrequency' => $this->hasInInterfaceFrequency,
                'hasInInterfaceDvb' => $this->hasInInterfaceDvb,
                'hasInInterfaceSatelite' => $this->hasInInterfaceSatelite,
                'hasInInterfacepolarization' => $this->hasInInterfacepolarization,
                'hasInInterfacepolarizationVoltage' => $this->hasInInterfacepolarizationVoltage,
                'hasInInterfaceSymbolRate' => $this->hasInInterfaceSymbolRate,
                'hasInInterfaceFec' => $this->hasInInterfaceFec,
                'hasInInterfaceLnb' => $this->hasInInterfaceLnb,
                'hasInInterfaceLnb22' => $this->hasInInterfaceLnb22,
                'hasIntinterfaceSatCard' => $this->hasIntinterfaceSatCard,
                'hasInInterfaceParabolaDiameter' => $this->hasInInterfaceParabolaDiameter,
                'hasInInterfaceSatelit' => $this->hasInInterfaceSatelit,
            ],
            outputs: [
                'outInterfaceName' => $this->outInterfaceName,
                'numberOfOutInterfaces' => $this->numberOfOutInterfaces,
                'hasOutInterfaceInInterface' => $this->hasOutInterfaceInInterface,
                'hasOutInterfaceSatCard' => $this->hasOutInterfaceSatCard,
                'hasOutInterfaceLnb' => $this->hasOutInterfaceLnb,
                'hasOutInterfacefaceSatelit' => $this->hasOutInterfacefaceSatelit,
            ],
            modules: [
                'moduleName' => $this->moduleName,
                'numberOfModules' => $this->numberOfModules,
            ]
        );

        $this->storeDrawer = false;
        $this->redirect('/devices/'.$this->device->id, true);

        return $engineResponse == true ? $this->success_alert('Šablona vytvořena') : $this->error_alert('Nepodařilo se vytvořit');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.create-device-template-component');
    }
}
