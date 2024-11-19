<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use Livewire\Component;
use App\Models\NanguIsp;
use App\Models\NanguSubscription;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaxPackageUsageExport;

class SettingsGeniusTvStatisticsPlusOrFilmChannelPackageComponent extends Component
{
    protected function isp_qeury_data(int $ispId)
    {
        return match ($ispId) {
            1 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            2 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%plus%")->where('offers', "not like", "%filmbox%")->count(),
            3 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            4 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            5 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            6 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            7 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            8 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            9 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            10 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            11 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            12 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            18 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            19 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            20 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            21 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            22 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            23 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            24 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            25 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            26 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('offers', "like", "%film%")->where('offers', "not like", "%filmbox%")->count(),
            27 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            28 => NanguSubscription::where('nangu_isp_id', $ispId)->where('subscriptionState', "!=", "SUSPENDED")->where('tariffCode', "like", "%plus%")->count(),
            default => 0
        };
    }

    public function usage(): array
    {
        $result = [];
        $nanguIsps = NanguIsp::get();

        foreach ($nanguIsps as $isp) {
            $result[] = [
                'isp' => $isp->name,
                'usage' => $this->isp_qeury_data($isp->id)
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
