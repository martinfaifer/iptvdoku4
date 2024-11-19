<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use Livewire\Component;
use App\Models\NanguIsp;
use App\Models\NanguSubscription;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaxPackageUsageExport;

class SettingsGeniusTvStatisticsPlusOrFilmChannelPackageComponent extends Component
{

    public function usage(): array
    {
        $result = [];
        $nanguIsps = NanguIsp::get();

        foreach ($nanguIsps as $isp) {
            $result[] = [
                'isp' => $isp->name,
                'usage' => NanguSubscription
                    ::where('nangu_isp_id', $isp->id)
                    ->where('subscriptionState', "!=", "SUSPENDED")
                    ->where('offers', "like", "%PLUS%")
                    ->count() + NanguSubscription
                    ::where('nangu_isp_id', $isp->id)
                    ->where('subscriptionState', "!=", "SUSPENDED")
                    ->Where('offers', "like", "%FILM%")
                    ->count()
            ];
        }

        return $result;
    }

    public function exportUsage()
    {
        $fileName = 'plus_or_film_usage.xlsx';
        return Excel::download(new MaxPackageUsageExport($this->usage()), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function render()
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-plus-or-film-channel-package-component', [
            'usage' => $this->usage()
        ]);
    }
}
