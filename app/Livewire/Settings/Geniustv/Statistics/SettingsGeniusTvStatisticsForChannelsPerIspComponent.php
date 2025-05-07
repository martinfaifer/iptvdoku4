<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use App\Exports\ChannelsUsagePerIspExport;
use App\Models\NanguIsp;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class SettingsGeniusTvStatisticsForChannelsPerIspComponent extends Component
{
    use WithPagination;

    public string $query = '';

    public function downloadChannelsMonthlyUsageReport(NanguIsp $nanguIsp): mixed
    {
        $fileName = str_replace(' ', '_', $nanguIsp->name).'_channels_usage.csv';

        return Excel::download(new ChannelsUsagePerIspExport($nanguIsp), $fileName, \Maatwebsite\Excel\Excel::CSV);
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
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-for-channels-per-isp-component', [
            'nanguIsps' => NanguIsp::search($this->query)->paginate(10),
            'headers' => [
                ['key' => 'name', 'label' => 'Poskytovatel', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
