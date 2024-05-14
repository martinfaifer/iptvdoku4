<?php

namespace App\Livewire\Iptv\Channels\Multicast;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChannelSource;
use App\Models\ChannelMulticast;
use Illuminate\Support\Collection;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Devices\DeviceHasChannelsTrait;
use App\Livewire\Forms\UpdateMulticastChannelForm;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;

class MulticastChannel extends Component
{
    use CheckIfChannelIsInIptvDohledTrait, NotificationTrait, DeviceHasChannelsTrait;

    public UpdateMulticastChannelForm $form;

    public ?Channel $channel;

    public bool $updateModal = false;

    public $channelSources;

    public Collection $devices;

    public Collection $backupDevices;

    public function mount()
    {
        $this->channelSources = ChannelSource::get();

        $temporaryDevices = Device::with('category')->get();

        $this->devices = $this->devices_belongs_to_channel_type(
            channelWithType: 'multicast:' . $this->channel->id
        );

        $this->backupDevices = $this->devices_belongs_to_channel_type(
            channelWithType: 'multicast:' . $this->channel->id . ':backup'
        );
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

        return $this->success_alert('Změněno');
    }

    public function closeModal()
    {
        return $this->updateModal = false;
    }

    public function destroy(ChannelMulticast $multicast)
    {
        $multicast->delete();
        $this->dispatch('update_multicasts.' . $this->channel->id);

        return $this->success_alert('Odebráno');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex items-center justify-center">
            <div>
                <span class="loading loading-dots loading-lg mt-16"></span>
            </div>
        </div>
        HTML;
    }

    #[On('echo:update_multicasts.{channel.id},BroadcastUpdateMulticastEvent')]
    #[On('update_multicasts.{channel.id}')]
    public function render()
    {
        return view('livewire.iptv.channels.multicast.multicast-channel', [
            // 'multicasts' => ChannelMulticast::where('channel_id', $this->channel->id)->with('channel_source')->get(),
            'multicasts' => $this->channel->multicasts->load('channel_source'),
        ]);
    }
}
