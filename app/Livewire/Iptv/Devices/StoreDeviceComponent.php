<?php

namespace App\Livewire\Iptv\Devices;

use App\Livewire\Forms\StoreDeviceForm;
use App\Models\DeviceCategory;
use App\Models\DeviceSnmp;
use App\Models\DeviceVendor;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class StoreDeviceComponent extends Component
{
    use NotificationTrait;

    public StoreDeviceForm $form;

    public bool $storeModal = false;

    public $deviceCategories;

    public $devicesVendors;

    public $deviceSnmps;

    public function mount()
    {
        $this->deviceCategories = DeviceCategory::get();
        $this->devicesVendors = DeviceVendor::get();
        $this->deviceSnmps = DeviceSnmp::get();
    }

    public function openModal()
    {
        return $this->storeModal = true;
    }

    public function closeDialog()
    {
        $this->resetErrorBag();

        return $this->storeModal = false;
    }

    public function store()
    {
        $device = $this->form->store();
        $this->closeDialog();

        $this->dispatch('update_devices_menu');

        $this->redirect('/devices/'.$device->id, true);

        return $this->success_alert('Zařízení přidáno');
    }

    public function render()
    {
        return view('livewire.iptv.devices.store-device-component');
    }
}
