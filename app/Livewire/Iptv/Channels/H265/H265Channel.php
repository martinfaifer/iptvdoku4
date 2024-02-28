<?php

namespace App\Livewire\Iptv\Channels\H265;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Models\ChannelQualityWithIp;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\UpdateH265ChannelForm;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;

class H265Channel extends Component
{
    use NotificationTrait, CheckIfChannelIsInIptvDohledTrait;

    public UpdateH265ChannelForm $form;

    public ?Channel $channel;

    public ?ChannelQualityWithIp $channelQualityWithIp;

    public array $h265 = [];

    public Collection $devices;

    public Collection $backupDevices;

    public bool $updateModal = false;

    public $quality;

    public function mount()
    {
        $this->devices = Device::get()->filter(function($device) {
            if(is_array($device->has_channels)) {
                    return in_array("h265:".$this->channel->id, $device->has_channels);
            }
        });

        $this->backupDevices = Device::get()->filter(function($device) {
            if(is_array($device->has_channels)) {
                    return in_array("h265:".$this->channel->id.":backup", $device->has_channels);
            }
        });
    }

    public function edit(ChannelQualityWithIp $channelQualityWithIp)
    {
        $this->form->setUnicast($channelQualityWithIp->load('channelQuality'));
        $this->quality = $channelQualityWithIp?->channelQuality?->name;
        $this->updateModal = true;
    }

    public function update()
    {
        $this->form->update();
        $this->closeModal();
        $this->dispatch('update_h265.' . $this->channel->id);
        return $this->success_alert("Změněno");
    }

    public function closeModal(): void
    {
        $this->updateModal = false;
        $this->resetErrorBag();
    }

    public function destroy(ChannelQualityWithIp $channelQualityWithIp)
    {
        $channelQualityWithIp->delete();
        $this->dispatch('update_h265.' . $this->channel->id);
        return $this->success_alert("Odebráno");
    }

    #[On('update_h265.{channel.id}')]
    public function render()
    {
        $this->h265 = [];
        if (!is_null($this->channel->h265)) {
            foreach ($this->channel->h265->ips as $ip) {
                $this->h265[] = [
                    'id' => $ip->id,
                    'ip' => $ip->ip,
                    'quality' => [
                        'id' => $ip->channelQuality->id,
                        'name' => $ip->channelQuality->name,
                        'bitrate' => $ip->channelQuality->bitrate
                    ]
                ];
            }
        }

        return view('livewire.iptv.channels.h265.h265-channel', [
            'h265' => $this->h265
        ]);
    }
}
