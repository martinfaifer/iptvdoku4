<?php

namespace App\Livewire\Iptv\Channels\H264;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Models\ChannelQualityWithIp;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\UpdateH264ChannelForm;

class H264Channel extends Component
{
    use NotificationTrait;

    public UpdateH264ChannelForm $form;

    public ?Channel $channel;

    public ?ChannelQualityWithIp $channelQualityWithIp;

    public array $h264 = [];

    public Collection $devices;
    public Collection $backupDevices;

    public bool $updateModal = false;

    public $quality;


    public function mount()
    {
        $this->devices = Device::get()->filter(function($device) {
            if(is_array($device->has_channels)) {
                    return in_array("h264:".$this->channel->id, $device->has_channels);
            }
        });

        $this->backupDevices = Device::get()->filter(function($device) {
            if(is_array($device->has_channels)) {
                    return in_array("h264:".$this->channel->id.":backup", $device->has_channels);
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
        $this->dispatch('update_h264.' . $this->channel->id);
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
        $this->dispatch('update_h264.' . $this->channel->id);
        return $this->success_alert("Odebráno");
    }

    #[On('update_h264.{channel.id}')]
    public function render()
    {
        $this->h264 = [];
        if (!is_null($this->channel->h264)) {
            foreach ($this->channel->h264->ips as $ip) {
                $this->h264[] = [
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

        return view('livewire.iptv.channels.h264.h264-channel', [
            'h264' => $this->h264
        ]);
    }
}
