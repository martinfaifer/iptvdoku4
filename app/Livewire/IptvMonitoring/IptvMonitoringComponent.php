<?php

namespace App\Livewire\IptvMonitoring;

use Livewire\Component;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;

class IptvMonitoringComponent extends Component
{
    use NotificationTrait;
    public bool $isMinimaze = false;
    public bool $isClosed = false;
    public mixed $user;

    public function mount(): void
    {
        $this->user = Auth::user();

        if ($this->user->iptv_monitoring_window == 'closed') {
            $this->isClosed = true;
        }

        if ($this->user->iptv_monitoring_window == 'minimaze') {
            $this->isClosed = false;
            $this->isMinimaze = true;
        }

        if ($this->user->iptv_monitoring_window == 'maximaze') {
            $this->isClosed = false;
            $this->isMinimaze = false;
        }
    }
    public function toStream(string $streamUrl): mixed
    {
        $channelQualityWithIp = ChannelQualityWithIp::where('ip', $streamUrl)->first();
        if ($channelQualityWithIp) {
            if (!blank($channelQualityWithIp->h264_id)) {
                return $this->redirect('/channels/' . $channelQualityWithIp->h264->channel_id . '/h264', true);
            }
            if (!blank($channelQualityWithIp->h265_id)) {
                return $this->redirect('/channels/' . $channelQualityWithIp->h265->channel_id . '/h265', true);
            }
        }
        $explodedStreamUrl = explode(":", $streamUrl);

        $channelMulticast = ChannelMulticast::where('stb_ip', $explodedStreamUrl[0])->first();
        if ($channelMulticast) {
            return $this->redirect('/channels/' . $channelMulticast->channel_id . '/multicast', true);
        }

        return $this->error_alert("Nepodařilo se najít kanál");
    }

    public function minimizeWindow(): bool
    {
        $this->user->update([
            'iptv_monitoring_window' => "minimaze"
        ]);
        return $this->isMinimaze = true;
    }

    public function maximizeWindow(): bool
    {
        $this->user->update([
            'iptv_monitoring_window' => "maximaze"
        ]);
        return $this->isMinimaze = false;
    }

    public function closeWindow(): bool
    {
        $this->user->update([
            'iptv_monitoring_window' => "closed"
        ]);
        return $this->isClosed = true;
    }

    public function render():\Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv-monitoring.iptv-monitoring-component', [
            'alerts' => Cache::get('iptv_dohled_all_alerts')
        ]);
    }
}
