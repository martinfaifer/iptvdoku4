<?php

namespace App\Livewire\Iptv\Devices\Menu;

use App\Models\Alert;
use Livewire\Component;

class DeviceMenuIconWithAlertComponent extends Component
{

    public string $dataType = 'Zařízení';
    public bool $isAlert = false;

    public function mount()
    {
        // check if today is some alert in device
        if (Alert::whereDate('created_at', now()->today())->first()) {
            $this->isAlert = true;
            $this->dataType = 'Na jednom či více zařízeních je problém!';
        }
    }

    public function render()
    {
        return view('livewire.iptv.devices.menu.device-menu-icon-with-alert-component');
    }
}
