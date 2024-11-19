<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use Livewire\Component;
use App\Models\NanguIsp;
use App\Models\NanguSubscription;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaxPackageUsageExport;

class SettingsGeniusTvStatisticsMaxChannelPackageComponent extends Component
{

    public function usage(): array
    {
        // FilmboxExtra1 is used in max channel package
        $result = [];
        $nanguIsps = NanguIsp::get();
        foreach ($nanguIsps as $isp) {
            $result[] = [
                'isp' => $isp->name,
                'usage' => NanguSubscription::where('channels', "like", "%FilmboxExtra1%")->where('subscriptionState', "!=", "SUSPENDED")->where('nangu_isp_id', $isp->id)->count()
            ];
        }

        return $result;
    }

    public function usage_of_golf_channel(): int
    {
        return NanguSubscription::where('channels', "like", "%GolfChannelHD%")->where('subscriptionState', "!=", "SUSPENDED")->count();
    }


    public function exportUsage()
    {
        $fileName = 'max_package_usage.xlsx';
        return Excel::download(new MaxPackageUsageExport($this->usage()), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }


    public function render()
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-max-channel-package-component', [
            'maxUsage' => $this->usage(),
            'golfChannel' => $this->usage_of_golf_channel()
        ]);
    }
}
