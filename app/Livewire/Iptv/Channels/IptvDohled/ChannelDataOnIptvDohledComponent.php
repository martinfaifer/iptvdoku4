<?php

namespace App\Livewire\Iptv\Channels\IptvDohled;

use Livewire\Component;
use Livewire\Attributes\Locked;
use App\Traits\Channels\GetChannelDataOnIptvDohledTrait;

class ChannelDataOnIptvDohledComponent extends Component
{
    use GetChannelDataOnIptvDohledTrait;

    #[Locked]
    public string $ip;

    public mixed $channelDataOnIptvDohled;

    public function mount(string $ip): void
    {
        $this->ip = $ip;
        $this->channelDataOnIptvDohled = $this->channel_on_dohled($ip);
    }

    public function create_chart(array $streamData): array
    {
        return [
            'type' => 'line',
            'data' => [
                'labels' => $streamData['xaxis'],
                'datasets' => [
                    [
                        'label' => '# of Votes',
                        'data' => $streamData['seriesData'],
                    ],
                ],
            ],
        ];
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component');
    }
}
