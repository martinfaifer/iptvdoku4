<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Models\RestartChannel;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class DeleteDeviceComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public function destroy(Device $device): void
    {
        // delete ssh ,alerts ,channel if can be restarted
        try {
            $device->ssh->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        RestartChannel::where('device_id', $device->id)->delete();
        $device->delete();

        $this->redirect('/devices', true);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.delete-device-component');
    }
}
