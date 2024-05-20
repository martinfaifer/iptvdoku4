<?php

namespace App\Livewire\Settings\Dashboard;

use App\Models\User;
use App\Models\Event;
use Livewire\Component;
use App\Models\NanguIsp;
use App\Models\WikiTopic;
use Livewire\Attributes\On;
use App\Exports\H264sExport;
use App\Exports\H265sExport;
use Livewire\Attributes\Url;
use App\Models\GeniusTvChart;
use App\Exports\ChannelsExport;
use App\Exports\DevicesExport;
use App\Exports\MulticastsExport;
use App\Exports\SatelitCardsExport;
use Livewire\Attributes\Computed;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Devices\CountDevicesTrait;
use App\Traits\Channels\CountChannelsTrait;
use Illuminate\Database\Eloquent\Collection;

class SettingsDashboardComponent extends Component
{
    use CountChannelsTrait, CountDevicesTrait;

    public int $channels = 0;
    public int $multicasts = 0;
    public int $h264s = 0;
    public int $h265s = 0;
    public int $devices = 0;
    public int $satCards = 0;

    public Collection $newestTopics;
    public Collection $newestUsers;
    public Collection $passedEvents;

    public array $chartData = [];
    public array $chartLables = [];

    #[Url]
    public string $nanguIsp = "7";
    public Collection $nanguIsps;
    public array $subscriptionsChartData = [];

    public function mount()
    {
        $this->channels = $this->count_channels();
        $this->multicasts = $this->count_multicasts();
        $this->h264s = $this->count_h264s();
        $this->h265s = $this->count_h265s();
        $this->devices = $this->count_devices();
        $this->satCards = $this->count_sat_cards();
        $this->nanguIsps = NanguIsp::get(['id', 'name']);
        $this->newestTopics = WikiTopic::orderBy('id', 'DESC')->take(5)->get(['id', 'title', 'creator']);
        $this->newestUsers = User::orderBy('id', 'DESC')->take(5)->get(['id', 'first_name', 'last_name', 'email', 'user_role_id', 'avatar_url']);
        $this->passedEvents = Event::where('start_date', '<=', now()->format('Y-m-d'))->orderBy('id', "DESC")->take(5)->get();
    }

    #[On('reload_new_nangu_isp_charts')]
    public function refresh_page()
    {
        return $this->redirect(url()->previous(), true);
    }

    public function get_subscriptions_chart_data()
    {
        $chartLables = [];
        $data = [];
        $subscriptions = GeniusTvChart
            ::where('nangu_isp_id', $this->nanguIsp == "" ? "7" : $this->nanguIsp)
            ->where('item', "subscriptions")
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($subscriptions->reverse() as $chartData) {
            array_push($chartLables, $chartData->created_at->format('d.m. Y'));
            array_push($data, (int) $chartData->value);
        }

        $this->subscriptionsChartData = [
            'labels' => $chartLables,
            'data' => $data
        ];
    }

    public function export_channels()
    {
        return Excel::download(new ChannelsExport, 'channels.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function export_multicasts()
    {
        return Excel::download(new MulticastsExport, 'multicasts.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function export_h264s()
    {
        return Excel::download(new H264sExport, 'h264s.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function export_h265s()
    {
        return Excel::download(new H265sExport, 'h265s.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function export_devices()
    {
        return Excel::download(new DevicesExport, 'devices.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function export_sat_cards()
    {
        return Excel::download(new SatelitCardsExport, 'satelit_cards.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function render()
    {
        $this->get_subscriptions_chart_data();
        return view('livewire.settings.dashboard.settings-dashboard-component');
    }
}
