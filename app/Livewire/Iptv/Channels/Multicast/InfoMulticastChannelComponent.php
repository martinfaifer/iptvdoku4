<?php

namespace App\Livewire\Iptv\Channels\Multicast;

use App\Livewire\Forms\UpdateMulticastChannelForm;
use App\Models\Channel;
use App\Models\ChannelMulticast;
use App\Models\ChannelSource;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;
use App\Traits\Devices\DeviceHasChannelsTrait;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class InfoMulticastChannelComponent extends Component
{
    use CheckIfChannelIsInIptvDohledTrait, DeviceHasChannelsTrait, NotificationTrait;

    public UpdateMulticastChannelForm $form;

    public Channel $channel;

    public bool $updateModal = false;

    public function edit(ChannelMulticast $multicast): void
    {
        $this->form->setMulticast($multicast);
        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->form->update();
        $this->closeModal();
        $this->dispatch('update_multicasts.'.$this->channel->id);

        // $this->dispatch('update_iptv_channel');
        // $this->redirect(url()->previous(), true);
        return $this->success_alert('Změněno');
    }

    public function closeModal(): void
    {
        $this->updateModal = false;
    }

    public function destroy(ChannelMulticast $multicast): mixed
    {
        $multicast->delete();
        // $this->dispatch('update_multicasts.' . $this->channel->id);
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    #[On('update_multicasts.{channel.id}')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        // dd($this->channel);
        return view('livewire.iptv.channels.multicast.info-multicast-channel-component', [
            'multicasts' => $this->channel->multicasts->load('channel_source'),
            'channelSources' => ChannelSource::get(),
        ]);
    }
}
