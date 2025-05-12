<?php

namespace App\Livewire\Settings\Devices\Templates;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeviceTemplateGpu;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsDeviceGpuModulTemplateForm;
use App\Livewire\Forms\UpdateSettingsDeviceGpuModulTemplateForm;

class SettingsDeviceGpuModulTemplateComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsDeviceGpuModulTemplateForm $createForm;
    public UpdateSettingsDeviceGpuModulTemplateForm $updateForm;

    public string $query = '';

    public bool $createModal = false;
    public bool $editModal = false;

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function create(): mixed
    {
        $this->createForm->submit();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function edit(DeviceTemplateGpu $deviceTemplateGpu): void
    {
        $this->updateForm->setDeviceTemplateGpu($deviceTemplateGpu);

        $this->editModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->submit();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function destroy(DeviceTemplateGpu $deviceGpuTemplate): mixed
    {
        $deviceGpuTemplate->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function closeDialog(): void
    {
        $this->createForm->reset();
        $this->updateForm->reset();
        $this->createModal = false;
        $this->editModal = false;
    }

    public function render()
    {
        return view('livewire.settings.devices.templates.settings-device-gpu-modul-template-component', [
            'headers' => [
                ['key' => 'name', 'label' => 'Model', 'class' => 'dark:text-white/80'],
                ['key' => 'max_streams', 'label' => 'Maximální počet streamů', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
            'gpus' => DeviceTemplateGpu::search($this->query)->paginate(5),
        ]);
    }
}
