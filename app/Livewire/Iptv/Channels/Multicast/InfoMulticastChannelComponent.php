<?php

namespace App\Livewire\Iptv\Channels\Multicast;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChannelSource;
use Livewire\Attributes\Locked;
use App\Models\ChannelMulticast;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\GetChannelSourceTrait;
use App\Traits\Devices\DeviceHasChannelsTrait;
use App\Livewire\Forms\UpdateMulticastChannelForm;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;

class InfoMulticastChannelComponent extends Component
{
    use CheckIfChannelIsInIptvDohledTrait, DeviceHasChannelsTrait, NotificationTrait, GetChannelSourceTrait;

    public UpdateMulticastChannelForm $form;

    #[Locked]
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
        $this->dispatch('update_multicasts.' . $this->channel->id);
        return $this->success_alert('Změněno');
    }

    public function closeModal(): void
    {
        $this->updateModal = false;
        $this->resetErrorBag();
    }

    public function destroy(ChannelMulticast $multicast): mixed
    {
        $multicast->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    #[On('update_multicasts.{channel.id}')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.channels.multicast.info-multicast-channel-component', [
            'multicasts' => $this->channel->multicasts->load('channel_source'),
            'channelSources' => $this->getCachedChannelSources(),
        ]);
    }
}
