<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Services\Api\Zabbix\ConnectService;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class DeviceComponent extends Component
{
    use NotificationTrait;

    public mixed $device = null;

    public ?array $nmsCahedData = null;

    public ?array $nimbleCachedData = null;

    public ?array $grapeTranscoderData = null;

    public bool $chartZabbixModal = false;
    public string $image = "";

    public function mount(mixed $device = null): void
    {
        if (!blank($device)) {
            if (!$deviceModel = Device::where('id', $device)->first()) {
                $this->redirect('/devices', true);
            } else {
                $this->device = $deviceModel;
            }
        } else {
            $this->device = $device;
        }
    }

    #[Computed()]
    public function availableCharts(string|int $zabbixId): mixed
    {
        return (new ConnectService())->getGraphIdFromItem(hostid: $zabbixId);
    }

    public function openZabbixChart(string|int $graphid)
    {
        $this->image = (new ConnectService())->getDeviceChart(graphid: $graphid);
        $this->chartZabbixModal = true;
    }

    public function closeDialog(): void
    {
        $this->chartZabbixModal = false;
        $this->image = "";
    }

    #[On('refresh_device')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_' . $this->device->id);
            $this->nimbleCachedData = Cache::get('nimble_' . $this->device->id . '_incoming_streams');
            $this->grapeTranscoderData = Cache::get(('grape_transcoder_' . $this->device->id));

            return view('livewire.iptv.devices.device-component')->title($this->device?->name);  // @phpstan-ignore-line
        }

        return view('livewire.iptv.devices.device-component');
    }
}
