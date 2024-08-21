<?php

namespace App\Livewire\Settings\Devices\Vendors;

use App\Livewire\Forms\CreateSettingsDevicesVendorsForm;
use App\Livewire\Forms\UpdateSettingsDevicesVendorsForm;
use App\Models\DeviceVendor;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsDevicesVendorsComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsDevicesVendorsForm $createForm;

    public UpdateSettingsDevicesVendorsForm $updateForm;

    public string $query = '';

    public bool $createModal = false;

    public bool $editModal = false;

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function create(): mixed
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function edit(DeviceVendor $deviceVendor): void
    {
        $this->updateForm->setVendor($deviceVendor);

        $this->editModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function destroy(DeviceVendor $deviceVendor): mixed
    {
        try {
            $deviceVendor->delete();

            return $this->success_alert('Odebráno');
        } catch (\Throwable $th) {
            return $this->error_alert('Existují vazby na výrobce');
        }
    }

    public function closeDialog(): void
    {
        $this->createForm->reset();
        $this->updateForm->reset();
        $this->editModal = false;
        $this->createModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.devices.vendors.settings-devices-vendors-component', [
            'headers' => [
                ['key' => 'name', 'label' => 'Výrobce', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
            'vendors' => DeviceVendor::search($this->query)->paginate(5),
        ]);
    }
}
