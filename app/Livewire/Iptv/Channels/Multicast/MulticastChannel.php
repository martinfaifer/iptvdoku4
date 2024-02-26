<?php

namespace App\Livewire\Iptv\Channels\Multicast;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChannelSource;
use App\Models\ChannelMulticast;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Collection;
use Livewire\Attributes\Modelable;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\Database\Query\Builder;
use App\Livewire\Forms\UpdateMulticastChannelForm;

class MulticastChannel extends Component
{
    use NotificationTrait;

    public UpdateMulticastChannelForm $form;

    public ?Channel $channel;
    public bool $updateModal = false;
    public $channelSources;

    public Collection $devices;
    public Collection $backupDevices;

    public function mount()
    {
        $this->channelSources = ChannelSource::get();

        $this->devices = Device::get()->filter(function($device) {
            if(is_array($device->has_channels)) {
                    return in_array("multicast:".$this->channel->id, $device->has_channels);
            }
        });

        $this->backupDevices = Device::get()->filter(function($device) {
            if(is_array($device->has_channels)) {
                    return in_array("multicast:".$this->channel->id.":backup", $device->has_channels);
            }
        });
    }

    public function edit(ChannelMulticast $multicast)
    {
        $this->form->setMulticast($multicast);
        $this->updateModal = true;
    }

    public function update()
    {
        $this->form->update();
        $this->closeModal();
        $this->dispatch('update_multicasts.' . $this->channel->id);
        return $this->success_alert("Změněno");
    }

    public function closeModal()
    {
        return $this->updateModal = false;
    }

    public function destroy(ChannelMulticast $multicast)
    {
        $multicast->delete();
        $this->dispatch('update_multicasts.' . $this->channel->id);
        return $this->success_alert("Odebráno");
    }

    #[On('update_multicasts.{channel.id}')]
    public function render()
    {
        return view('livewire.iptv.channels.multicast.multicast-channel', [
            'multicasts' => ChannelMulticast::where('channel_id', $this->channel->id)->with('channel_source')->get(),
        ]);
    }
}
