<?php

namespace App\Exports;

use App\Models\NanguIsp;
use App\Models\NanguSubscription;
use App\Models\GeniusTVChannelsOffersTax;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OffersUsageExport implements FromView
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


    public function view(): View
    {
        return view('exports.offers-usage', [
            'offersUsage' => $this->offers_usage()
        ]);
    }
}
