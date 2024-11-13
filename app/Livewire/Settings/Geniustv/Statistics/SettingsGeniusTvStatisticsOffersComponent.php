<?php
namespace App\Livewire\Settings\GeniusTv\Statistics;

use Livewire\Component;
use App\Models\NanguIsp;
use App\Models\NanguSubscription;
use App\Exports\OffersUsageExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\GeniusTVChannelsOffersTax;

class SettingsGeniusTvStatisticsOffersComponent extends Component
{

    public function offers_usage(): array
    {
        $result = [];
        $offers = GeniusTVChannelsOffersTax::get();
        $nanguIsps = NanguIsp::get();
        foreach ($offers as $offer) {
            foreach ($nanguIsps as $isp) {
                $numberOfOfferUsage = NanguSubscription
                    ::where('nangu_isp_id', $isp->id)
                    ->where('offers', "like", "%" . $offer->offer . "%")
                    ->where('subscriptionState', "!=", "SUSPENDED")
                    ->count();

                if ($numberOfOfferUsage != 0) {
                    $result[$isp->name][$offer->offer] = $numberOfOfferUsage;
                }
            }
        }

        return $result;
    }

    public function exportToCsv()
    {
        $fileName = 'offers_usage.csv';
        return Excel::download(new OffersUsageExport(), $fileName);
    }

    public function render()
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-offers-component', [
            'offersUsage' => $this->offers_usage()
        ]);
    }
}
