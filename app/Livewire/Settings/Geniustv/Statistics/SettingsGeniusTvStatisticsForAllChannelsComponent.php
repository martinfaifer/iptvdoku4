<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use App\Exports\ChannelsUsageExport;
use App\Models\Channel;
use App\Models\GeniusTvChart;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SettingsGeniusTvStatisticsForAllChannelsComponent extends Component
{
    public string $query = '';

    public function get_channels_usage(): array
    {
        $statisticsForAllChannels = [];
        $channels = Channel::search($this->query)->withNanguChannelCode()->get(['id', 'name', 'nangu_channel_code']);

        foreach ($channels as $channel) {
            $statisticsForAllChannels[] = [
                'name' => $channel->name,
                'amount' => GeniusTvChart::withoutNanguIsp()->isChannel($channel->id)->take(2)->orderBy('id', 'DESC')->get(),
            ];
        }

        return $statisticsForAllChannels;
    }

    public function exportChannelsUsageToCsv(): mixed
    {
        $fileName = 'channels_usage.csv';

        return Excel::download(new ChannelsUsageExport(), $fileName, \Maatwebsite\Excel\Excel::CSV);
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div class="flex flex-col gap-4 w-52">
            <div class="skeleton h-32 w-full"></div>
            <div class="skeleton h-4 w-28"></div>
            <div class="skeleton h-4 w-full"></div>
            <div class="skeleton h-4 w-full"></div>
        </div>
        HTML;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-for-all-channels-component', [
            'statisticsForAllChannels' => $this->get_channels_usage(),
            'headers' => [
                ['key' => 'name', 'label' => 'Kanál', 'class' => 'text-white/80'],
                ['key' => 'amount_last_month', 'label' => 'Předchozí měsíc', 'class' => 'text-white/80'],
                ['key' => 'amount_this_month', 'label' => 'Tento měsíc', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
