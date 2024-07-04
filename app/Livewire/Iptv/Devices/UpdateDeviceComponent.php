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

    public $deviceCategories;

    public $devicesVendors;

    public $deviceSnmps;

    public function mount()
    {
        $this->deviceCategories = DeviceCategory::get();
        $this->devicesVendors = $this->get_device_vendors();
        $this->deviceSnmps = DeviceSnmp::get();
    }

    public function edit()
    {
        $this->form->setDevice($this->device);

        return $this->updateModal = true;
    }

    public function closeDialog()
    {
        $this->resetErrorBag();

        return $this->updateModal = false;
    }

    public function update()
    {
        $this->form->update();
        $this->closeDialog();

        $this->dispatch('update_devices_menu');
        $this->dispatch('refresh_device');

        // $this->redirect('/devices/' . $this->device->id, true);

        return $this->success_alert('Zařízení upraveno');
    }

    public function render()
    {
        return view('livewire.iptv.devices.update-device-component');
    }
}
