<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Livewire\Component;
use App\Models\RestartChannel;
use App\Traits\Livewire\NotificationTrait;
use App\Actions\Devices\DeleteDeviceAction;

class DeleteDeviceComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public function destroy(Device $device): void
    {
        // delete ssh ,alerts ,channel if can be restarted
        try {
            $device->ssh->delete();
            RestartChannel::where('device_id', $device->id)->delete();
            (new DeleteDeviceAction($device))();
        } catch (\Throwable $th) {
            //throw $th;
        }
        $device->delete();

        $this->redirect('/devices', true);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.delete-device-component');
    }
}
