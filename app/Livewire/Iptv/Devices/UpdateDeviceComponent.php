<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Livewire\Component;
use App\Models\DeviceSnmp;
use App\Models\DeviceVendor;
use App\Models\DeviceCategory;
use App\Livewire\Forms\UpdateDeviceForm;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Devices\GetDeviceVendorsTrait;

class UpdateDeviceComponent extends Component
{
    use NotificationTrait, GetDeviceVendorsTrait;

    public UpdateDeviceForm $form;

    public ?Device $device;

    public bool $updateModal = false;

    public mixed $deviceCategories;

    public mixed $devicesVendors;

    public mixed $deviceSnmps;

    public function mount(): void
    {
        $this->deviceCategories = DeviceCategory::get();
        $this->devicesVendors = $this->get_device_vendors();
        $this->deviceSnmps = DeviceSnmp::get();
    }

    public function edit(): void
    {
        $this->form->setDevice($this->device);

        $this->updateModal = true;
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();

        $this->updateModal = false;
    }

    public function update(): mixed
    {
        $this->form->update();
        $this->closeDialog();

        $this->dispatch('update_devices_menu');
        $this->dispatch('refresh_device');

        // $this->redirect('/devices/' . $this->device->id, true);

        return $this->success_alert('Zařízení upraveno');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.update-device-component');
    }
}
