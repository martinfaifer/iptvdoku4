<?php

namespace App\Livewire\Iptv\Devices\Zabbix;

use Livewire\Component;
use App\Services\Api\Zabbix\ConnectService;

class DeviceZabbixChartComponent extends Component
{

    public $charts;

    public function mount()
    {
        $this->charts = (new ConnectService())->getGraphIdFromItem('13273');
    }

    public function render()
    {
        return view('livewire.iptv.devices.zabbix.device-zabbix-chart-component');
    }
}
