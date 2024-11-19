<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use Livewire\Component;
use App\Models\NanguIsp;
use App\Exports\HboUsageExport;
use App\Models\NanguSubscription;
use Maatwebsite\Excel\Facades\Excel;

class SettingsGeniusTvStatisticsHboStatsComponent extends Component
{

    public function hbo_usage(): array
    {
        $result = [];
        $isps = NanguIsp::get();

        foreach ($isps as $isp) {
            $result[$isp->name] =
                NanguSubscription
                ::where('nangu_isp_id', $isp->id)
                ->where('channels', "like", "%hbo%")
                ->where("channels", "not like", "%cinemax%")
                ->where('subscriptionState', "!=", "SUSPENDED")
                ->where('nangu_isp_id', $isp->id)
                ->count();
        }

        return $result;
    }

    public function hbo_max_usage(): array
    {
        $result = [];
        $isps = NanguIsp::get();

        foreach ($isps as $isp) {
            $result[$isp->name] =
                NanguSubscription
                ::where('nangu_isp_id', $isp->id)
                ->where('offers', "like", "%TV HBO MAX%")
                ->where('subscriptionState', "!=", "SUSPENDED")
                ->where('nangu_isp_id', $isp->id)
                ->count();
        }

        return $result;
    }

    public function exportHboUsageToCsv()
    {
        $usage = $this->hbo_usage();
        return Excel::download(new HboUsageExport($usage), "Využití_HBO.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportHboMxUsageToCsv()
    {
        $usage = $this->hbo_max_usage();
        return Excel::download(new HboUsageExport($usage), "Využití_HBO_MAX.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }


    public function render()
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-hbo-stats-component', [
            'hbo_usage' => $this->hbo_usage(),
            'hbo_max_usage' => $this->hbo_max_usage()
        ]);
    }
}
