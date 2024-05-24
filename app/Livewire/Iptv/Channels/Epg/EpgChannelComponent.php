<?php

namespace App\Livewire\Iptv\Channels\Epg;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Traits\Dates\DateParserTrait;
use App\Services\Api\Epg\EpgConnectService;

class EpgChannelComponent extends Component
{
    use DateParserTrait;
    public ?Channel $channel;

    public $epg;

    #[Url]
    public $dayInMonth;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
        $this->epg = $this->load_epg();
    }

    public function load_epg()
    {
        if (blank($this->dayInMonth)) {
            $this->dayInMonth = now()->format('Y-m-d');
        }

        return (new EpgConnectService())->get_channel_epg($this->channel->epg_id, $this->dayInMonth, $this->dayInMonth);
    }

    #[On('reload_channel_epg')]
    public function reload_channel_epg()
    {
        return $this->redirect(url()->previous(), true);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col gap-4 w-52">
                <div class="skeleton h-32 w-full"></div>
                <div class="skeleton h-4 w-28"></div>
                <div class="skeleton h-4 w-full"></div>
                <div class="skeleton h-4 w-full"></div>
            </div>
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.iptv.channels.epg.epg-channel-component');
    }
}
