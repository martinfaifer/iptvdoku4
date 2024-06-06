<?php

namespace App\Livewire\Iptv\Channels\H265;

use App\Livewire\Forms\UpdateH265ChannelForm;
use App\Models\Channel;
use App\Models\ChannelQualityWithIp;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;
use App\Traits\Devices\DeviceHasChannelsTrait;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class H265Channel extends Component
{
    use CheckIfChannelIsInIptvDohledTrait, DeviceHasChannelsTrait, NotificationTrait;

    public UpdateH265ChannelForm $form;

    public ?Channel $channel;

    public ?ChannelQualityWithIp $channelQualityWithIp;

    public array $h265 = [];

    public bool $updateModal = false;

    public $quality;

    public function edit(ChannelQualityWithIp $channelQualityWithIp)
    {
        $this->form->setUnicast($channelQualityWithIp->load('channelQuality'));
        $this->quality = $channelQualityWithIp?->channelQuality?->name;

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->form->update();
        $this->closeModal();
        $this->dispatch('update_h265.'.$this->channel->id);

        return $this->success_alert('Změněno');
    }

    public function closeModal()
    {
        $this->resetErrorBag();

        return $this->updateModal = false;
    }

    public function destroy(ChannelQualityWithIp $channelQualityWithIp)
    {
        $channelQualityWithIp->delete();
        $this->dispatch('update_h265.'.$this->channel->id);

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

    #[On('update_h265.{channel.id}')]
    public function render()
    {
        $this->h265 = [];
        if (! is_null($this->channel->h265)) {
            foreach ($this->channel->h265->ips->load('channelQuality') as $ip) {
                $this->h265[] = [
                    'id' => $ip->id,
                    'ip' => $ip->ip,
                    'quality' => [
                        'id' => $ip->channelQuality->id,
                        'name' => $ip->channelQuality->name,
                        'bitrate' => $ip->channelQuality->bitrate,
                    ],
                ];
            }
        }

        return view('livewire.iptv.channels.h265.h265-channel', [
            'h265' => $this->h265,
        ]);
    }
}
