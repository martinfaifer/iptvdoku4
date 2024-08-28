<?php

namespace App\Livewire\Iptv\Channels\H265;

use App\Livewire\Forms\UpdateH265ChannelForm;
use App\Models\Channel;
use App\Models\ChannelQualityWithIp;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;
use App\Traits\Devices\DeviceHasChannelsTrait;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class H265Channel extends Component
{
    use CheckIfChannelIsInIptvDohledTrait, DeviceHasChannelsTrait, NotificationTrait;

    public UpdateH265ChannelForm $form;

    #[Locked]
    public ?Channel $channel;

    public ?ChannelQualityWithIp $channelQualityWithIp;

    public array $h265 = [];

    public bool $updateModal = false;

    public ?string $quality;

    public function edit(ChannelQualityWithIp $channelQualityWithIp): void
    {
        $this->form->setUnicast($channelQualityWithIp->load('channelQuality'));
        $this->quality = $channelQualityWithIp?->channelQuality?->name;  // @phpstan-ignore-line

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->form->update();
        $this->closeModal();
        $this->redirect(url()->previous(), true);
        return $this->success_alert('Změněno');
    }

    public function closeModal(): void
    {
        $this->resetErrorBag();

        $this->updateModal = false;
    }

    public function destroy(ChannelQualityWithIp $channelQualityWithIp): mixed
    {
        $channelQualityWithIp->delete();
        $this->redirect(url()->previous(), true);
        return $this->success_alert('Odebráno');
    }

    public function placeholder(): string
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
    public function render(): \Illuminate\Contracts\View\View|Factory
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
