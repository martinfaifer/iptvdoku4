<?php

namespace App\Livewire\Iptv\Devices;

use App\Livewire\Forms\StoreDeviceForm;
use App\Models\DeviceCategory;
use App\Models\DeviceSnmp;
use App\Traits\Devices\GetDeviceVendorsTrait;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class StoreDeviceComponent extends Component
{
    use GetDeviceVendorsTrait, NotificationTrait;

    public StoreDeviceForm $form;

    public bool $storeModal = false;

    public mixed $deviceCategories;

    public mixed $devicesVendors;

    public mixed $deviceSnmps;

    public function mount(): void
    {
        $this->deviceCategories = DeviceCategory::get();
        $this->devicesVendors = $this->get_device_vendors();
        $this->deviceSnmps = DeviceSnmp::get();
    }

    public function openModal(): void
    {
        $this->storeModal = true;
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();

        $this->storeModal = false;
    }

    public function store(): mixed
    {
        $device = $this->form->store();
        $this->closeDialog();

        $this->dispatch('update_devices_menu');

        $this->redirect('/devices/'.$device->id, true);

        return $this->success_alert('Zařízení přidáno');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.store-device-component');
    }
}
