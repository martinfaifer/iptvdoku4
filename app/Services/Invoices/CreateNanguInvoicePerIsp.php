<?php

namespace App\Services\Invoices;

use App\Models\Channel;
use App\Models\Chart;
use App\Models\NanguIsp;
use Illuminate\Support\Str;
use App\Models\NanguSubscriber;
use App\Models\GeniusTVStaticTax;
use App\Models\NanguSubscription;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\GeniusTVchannelsTax;
use App\Models\GeniusTVChannelsOffersTax;
use App\Models\GeniusTVchannelPackagesTax;
use App\Models\GeniusTvChart;
use App\Models\NanguIspInvoice;
use App\Models\NanguIspMontlyInvoicesData;
use App\Services\Invoices\HBOGO\ConnectService;
use App\Services\Invoices\Traits\CurrencyPriceTrait;

class CreateNanguInvoicePerIsp
{
    use CurrencyPriceTrait;

    public function create()
    {
        $hboGoTax = GeniusTVStaticTax::where('name', "osaHBOGO")->first();
        $taxesForTarrifs = [];
        NanguIsp::with('discount', 'subscriptions')->each(function ($isp) use ($taxesForTarrifs, $hboGoTax) {
            $hboGoCount = 0;
            // get all static taxes
            $allActiveSubscriptionCount = NanguSubscription::forIsp($isp->id)->isBilling()->count();
            $staticTaxesForSingleSubscription = $this->staticTaxesForSubsciptions($isp);
            $tarrifCodes = $this->selectUniqueTarrifCodes($isp->id);

            foreach ($tarrifCodes as $tarrifCode) {
                $numberOfCustomersInTarrif = NanguSubscription::forIsp($isp->id)->isBilling()->tarrifCode($tarrifCode)->count();

                $channelsTaxes = (float)$this->channelsTaxes(ispId: $isp->id, tarrifCode: $tarrifCode);
                $channelPackageTaxes = (float)$this->channelPackagesTaxes(ispId: $isp->id, tarrifCode: $tarrifCode);

                $cost = $channelsTaxes + $channelPackageTaxes;

                $offerTaxes = (float)$this->offerTaxes(ispId: $isp->id, tarrifCode: $tarrifCode);

                $taxesForTarrifs[$tarrifCode] = [
                    'count' => $numberOfCustomersInTarrif,
                    'pricePerSubscription' => $cost + $staticTaxesForSingleSubscription,
                    'cost' => $numberOfCustomersInTarrif * ($cost + $staticTaxesForSingleSubscription) + $offerTaxes
                ];
            }

            $sumPrice = 0;
            $taxesForTarrifs['osaData'] = [
                'allCustomers' => $allActiveSubscriptionCount,
                'staticTaxes' => round($staticTaxesForSingleSubscription, 2),
                'priceForStaticTaxesWithAllCustomers' => round($sumPrice, 2)
            ];

            // HboGo / HBO MAX / MAX
            if (!is_null($isp->hbo_key)) {
                $hboGoCount = (new ConnectService())->count_all_results($isp->hbo_key);
                $taxesForTarrifs['hbogo'] = [
                    'count' => $hboGoCount,
                    'pricePerSubscription' => $hboGoTax->price,
                    'cost' => $hboGoCount * $hboGoTax->price
                ];
            }

            foreach ($taxesForTarrifs as $taxForTarrif) {
                if (array_key_exists('cost', $taxForTarrif)) {
                    $sumPrice = (float)$sumPrice + (float)$taxForTarrif['cost'];
                }
            }

            if ($invoice = NanguIspMontlyInvoicesData::where('nangu_isp_id', $isp->id)->first()) {
                $invoice->update([
                    'invoice_data' => json_encode($taxesForTarrifs),
                    'price' => round($sumPrice, 2)
                ]);
            } else {
                NanguIspMontlyInvoicesData::create([
                    'nangu_isp_id' => $isp->id,
                    'invoice_data' => json_encode($taxesForTarrifs),
                    'price' => round($sumPrice, 2)
                ]);
            }
            // create pdf and store them in to the file storage and create link to db for download
            $invoiceName = str_replace(" ", "", $isp->name) . "_" . time() . ".pdf";
            Pdf::view('pdfs.invoice', [
                'allActiveSubscriptionCount' => $allActiveSubscriptionCount,
                'tarrifs' => $taxesForTarrifs,
                'sum' => $sumPrice
            ])->save("storage/invoices/" . $invoiceName);

            NanguIspInvoice::create([
                'nangu_isp_id' => $isp->id,
                'invoice' => $invoiceName,
                'path' => public_path("storage/invoices/" . $invoiceName)
            ]);

            GeniusTvChart::create([
                'item' => "hbogo",
                'value' => $hboGoCount,
                'nangu_isp_id' => $isp->id
            ]);
        });
    }

    protected function staticTaxesForSubsciptions($isp)
    {
        $sum = 0;

        $staticTaxes = GeniusTVStaticTax::with('currency_name')->subscriptionTaxes($isp->is_akcionar)->get();
        foreach ($staticTaxes as $staticTax) {
            $sum = $this->calc_tax(tax: $sum, model: $staticTax);
        }

        if (!is_null($isp->discount)) {
            return (float)$sum - (float)$isp->discount->discount;
        }

        return $sum;
    }

    protected function selectUniqueTarrifCodes(int $ispId): array
    {
        $tarrifCodes = [];
        foreach (NanguSubscription::forIsp($ispId)->isBilling()->uniqueTariffCodes() as $tarrifCode) {
            array_push($tarrifCodes, $tarrifCode->tariffCode);
        }

        return $tarrifCodes;
    }

    /**
     * searching for channels belongs to specific nanguIsp and tarrifCode
     * channels are searching by $channel->nangu_channel_code
     */
    protected function channelsTaxes(int $ispId, string $tarrifCode): int|float
    {
        $tax = 0;

        $channelsTaxes = GeniusTVchannelsTax::with('channel', 'currency_name')->get();

        foreach ($channelsTaxes as $channelTax) {
            // channel exist
            if ($channel = NanguSubscription
                ::forIsp($ispId)
                ->isBilling()
                ->tarrifCode($tarrifCode)
                ->hasChannel($channelTax->channel->nangu_channel_code)
                ->first()
            ) {
                $tax = $this->calc_tax(tax: $tax, model: $channelTax);
            }
        }

        return $tax;
    }

    protected function channelPackagesTaxes(int $ispId, string $tarrifCode)
    {
        $tax = 0;

        foreach (GeniusTVchannelPackagesTax::with('currency_name')->get() as $channelPackage) {
            $channelsInPackage = Channel::find(json_decode($channelPackage->channels_id));

            // exception dont exists
            if (is_null($channelPackage->exception)) {
                // count tax for all channels must be in channel package
                if ($channelPackage->must_contains_all == true) {
                    $tax = (float)$tax + (float)$this->count_channel_package_tax_for_all_channels_without_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage);
                } else {
                    // count if contains only one channel
                    $tax = (float)$tax + (float)$this->count_channel_package_tax_for_channels_without_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage);
                }
            } else {
                // exception channels
                $exceptionsInPackage = Channel::find(json_decode($channelPackage->exception));
                $arrayOfExceptions = [];
                foreach ($exceptionsInPackage as $exceptionChannel) {
                    array_push($arrayOfExceptions, $exceptionChannel->nangu_channel_code);
                }
                $arrayOfSearcheableChannelCodes = [];

                foreach ($channelsInPackage as $channelInPackage) {
                    array_push($arrayOfSearcheableChannelCodes, $channelInPackage->nangu_channel_code);
                }

                if ($channelPackage->must_contains_all == true) {

                    $tax = $tax + $this->count_channel_package_tax_for_all_channels_with_exception(
                        $arrayOfSearcheableChannelCodes,
                        $ispId,
                        $tarrifCode,
                        $channelPackage,
                        $arrayOfExceptions
                    );
                } else {
                    $tax = $tax + $this->count_channel_package_tax_for_channels_with_exception(
                        $arrayOfSearcheableChannelCodes,
                        $ispId,
                        $tarrifCode,
                        $channelPackage,
                        $arrayOfExceptions
                    );
                }
            }
        }

        return $tax;
    }

    protected function offerTaxes(int $ispId, string $tarrifCode)
    {
        $tax = 0;
        foreach (GeniusTVChannelsOffersTax::with('currency_name')->get() as $geniustvOffer) {
            $numberOfActiveSubscriptionInOffer = NanguSubscription::forIsp($ispId)->isBilling()->offerCode($geniustvOffer->offer)->tarrifCode($tarrifCode)->count();
            $tax = $this->calc_tax_with_number_of_customers($tax, $geniustvOffer, $numberOfActiveSubscriptionInOffer);
        }

        return $tax;
    }


    private function count_channel_package_tax_for_all_channels_without_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage)
    {
        $tax = 0;
        $arrayOfSearcheableChannelCodes = [];
        foreach ($channelsInPackage as $channelInPackage) {
            array_push($arrayOfSearcheableChannelCodes, $channelInPackage->nangu_channel_code);
        }

        $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->first();
        if (Str::containsAll($subscriptionInTarrif->channels, $arrayOfSearcheableChannelCodes)) {
            $tax = $this->calc_tax(tax: $tax, model: $channelPackage);
        }

        return $tax;
    }

    private function count_channel_package_tax_for_channels_without_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage)
    {
        $tax = 0;
        foreach ($channelsInPackage as $channelInPackage) {
            $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->hasChannel($channelInPackage->nangu_channel_code)->first();
            if ($subscriptionInTarrif) {
                $tax = $this->calc_tax(tax: $tax, model: $channelPackage);

                return $tax;
            }
        }

        return $tax;
    }

    private function count_channel_package_tax_for_all_channels_with_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage, $arrayOfExceptions)
    {
        $tax = 0;
        $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->first();
        if ($subscriptionInTarrif) {
            if (Str::containsAll($subscriptionInTarrif->channels, $channelsInPackage) && !Str::containsAll($subscriptionInTarrif->channels, $arrayOfExceptions)) {
                $tax = $this->calc_tax(tax: $tax, model: $channelPackage);
            }
        }

        return $tax;
    }

    private function count_channel_package_tax_for_channels_with_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage, $arrayOfExceptions)
    {
        $tax = 0;
        foreach ($channelsInPackage as $channelInPackage) {

            $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->first();
            if ($subscriptionInTarrif) {
                if (Str::contains($subscriptionInTarrif->channels, $channelInPackage) && !Str::containsAll($subscriptionInTarrif->channels, $arrayOfExceptions)) {
                    $tax = $this->calc_tax(tax: $tax, model: $channelPackage);
                }
                return $tax;
            }
        }

        return $tax;
    }
}
