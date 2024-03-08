<?php

namespace App\Livewire\Iptv\Channels\IptvDohled;

use App\Traits\Channels\GetChannelDataOnIptvDohledTrait;
use Livewire\Component;

class ChannelDataOnIptvDohledComponent extends Component
{
    use GetChannelDataOnIptvDohledTrait;

    public string $ip;

    public $channelDataOnIptvDohled;

    public function mount(string $ip)
    {
        $this->ip = $ip;
        $this->channelDataOnIptvDohled = $this->channel_on_dohled($ip);
    }

    public function create_chart($streamData)
    {
        [
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

    public function render()
    {
        return view('livewire.iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component');
    }
}
