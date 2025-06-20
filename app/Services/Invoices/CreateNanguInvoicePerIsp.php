<?php

namespace App\Services\Invoices;

use App\Models\Channel;
use App\Models\GeniusTVchannelPackagesTax;
use App\Models\GeniusTVChannelsOffersTax;
use App\Models\GeniusTVchannelsTax;
use App\Models\GeniusTvChart;
use App\Models\GeniusTVStaticTax;
use App\Models\NanguIsp;
use App\Models\NanguIspInvoice;
use App\Models\NanguIspMontlyInvoicesData;
use App\Models\NanguSubscription;
use App\Services\Api\Adminus\ConnectService as AdminusConnectService;
use App\Services\Invoices\HBOGO\ConnectService;
use App\Services\Invoices\Traits\CurrencyPriceTrait;
use Barryvdh\DomPDF\Facade\Pdf;
// use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Str;

class CreateNanguInvoicePerIsp
{
    use CurrencyPriceTrait;

    public function create(): void
    {
        $hboGoTax = GeniusTVStaticTax::where('name', 'osaHBOGO')->first();
        $taxesForTarrifs = [];
        NanguIsp::with('discount', 'subscriptions')->each(function ($isp) use ($taxesForTarrifs, $hboGoTax) {
            $offerTaxes = 0;
            $hboGoCount = 0;
            // get all static taxes
            $allActiveSubscriptionCount = NanguSubscription::forIsp($isp->id)->isBilling()->count();
            $staticTaxesForSingleSubscription = $this->staticTaxesForSubsciptions($isp);
            $tarrifCodes = $this->selectUniqueTarrifCodes($isp->id);
            // dd($tarrifCodes, $isp->name);
            foreach ($tarrifCodes as $tarrifCode) {
                $numberOfCustomersInTarrif = NanguSubscription::forIsp($isp->id)->isBilling()->tarrifCode($tarrifCode)->count();

                $offerTaxes = (float) $this->offerTaxes(ispId: $isp->id, tarrifCode: $tarrifCode);

                // if offerTaxes != 0 must remove channels or packages from offer
                if ($offerTaxes != 0) {
                    // dd($offerTaxes, $tarrifCode, $isp->id,  $isp->name);
                    $channelsTaxes = $this->channelsTaxesIfIsOfferIncluded(ispId: $isp->id, tarrifCode: $tarrifCode);
                    // dd($offerTaxes, $tarrifCode, $isp->id,  $isp->name, $channelsTaxes);
                    $channelPackageTaxes = (float) 0;
                } else {
                    $channelsTaxes = (float) $this->channelsTaxes(ispId: $isp->id, tarrifCode: $tarrifCode);
                    $channelPackageTaxes = (float) $this->channelPackagesTaxes(ispId: $isp->id, tarrifCode: $tarrifCode);
                }

                $cost = $channelsTaxes + $channelPackageTaxes;

                // if ($offerTaxes != 0) {
                //     dd($tarrifCode, $channelsTaxes, $channelPackageTaxes, $offerTaxes, $numberOfCustomersInTarrif, $staticTaxesForSingleSubscription);
                // }
                $taxesForTarrifs[$tarrifCode] = [
                    'count' => $numberOfCustomersInTarrif,
                    'pricePerSubscription' => $cost + $staticTaxesForSingleSubscription + $offerTaxes,
                    'cost' => $numberOfCustomersInTarrif * ($cost + $staticTaxesForSingleSubscription) + $offerTaxes,
                ];
            }

            $sumPrice = 0;
            $taxesForTarrifs['osaData'] = [
                'allCustomers' => $allActiveSubscriptionCount,
                'staticTaxes' => round($staticTaxesForSingleSubscription, 2),
                'priceForStaticTaxesWithAllCustomers' => round($sumPrice, 2),
            ];

            // HboGo / HBO MAX / MAX
            if (! is_null($isp->hbo_key)) {
                try {
                    $hboGoCount = (new ConnectService())->count_all_results($isp->hbo_key);
                    $taxesForTarrifs['hbogo'] = [
                        'count' => $hboGoCount,
                        'pricePerSubscription' => $hboGoTax->price,
                        'cost' => $hboGoCount * $hboGoTax->price,
                    ];
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            foreach ($taxesForTarrifs as $taxForTarrif) {
                if (array_key_exists('cost', $taxForTarrif)) {
                    $sumPrice = (float) $sumPrice + (float) $taxForTarrif['cost'];
                    // dd($sumPrice);
                }
            }

            if ($invoice = NanguIspMontlyInvoicesData::where('nangu_isp_id', $isp->id)->first()) {
                $invoice->update([
                    'invoice_data' => json_encode($taxesForTarrifs),
                    'price' => round($sumPrice, 2),
                ]);
            } else {
                NanguIspMontlyInvoicesData::create([
                    'nangu_isp_id' => $isp->id,
                    'invoice_data' => json_encode($taxesForTarrifs),
                    'price' => round($sumPrice, 2),
                ]);
            }
            // create pdf and store them in to the file storage and create link to db for download
            $invoiceName = str_replace(' ', '', $isp->name) . '_' . time() . '.pdf';
            Pdf::loadView('pdfs.invoice', [
                'allActiveSubscriptionCount' => $allActiveSubscriptionCount,
                'tarrifs' => $taxesForTarrifs,
                'sum' => $sumPrice,
                'isp' => $isp,
            ])->save('storage/app/public/invoices/' . $invoiceName);

            NanguIspInvoice::create([
                'nangu_isp_id' => $isp->id,
                'invoice' => $invoiceName,
                'path' => '/storage/invoices/' . $invoiceName,
            ]);

            // send to adminus for create invoice with bound to flexibee
            // if (!blank($isp->crm_contract_id) && $sumPrice != 0) {
            //     (new AdminusConnectService())->create_invoice(contractId: $isp->crm_contract_id, price: $sumPrice);
            // }

            GeniusTvChart::create([
                'item' => 'hbogo',
                'value' => $hboGoCount,
                'nangu_isp_id' => $isp->id,
            ]);
        });
    }

    protected function staticTaxesForSubsciptions(object $isp): int|float
    {
        $sum = 0;

        $staticTaxes = GeniusTVStaticTax::with('currency_name')->subscriptionTaxes($isp->is_akcionar)->get();
        foreach ($staticTaxes as $staticTax) {
            $sum = $this->calc_tax(tax: $sum, model: $staticTax);
        }

        if (! is_null($isp->discount)) {
            return (float) $sum - (float) $isp->discount->discount;
        }

        return $sum;
    }

    protected function selectUniqueTarrifCodes(int $ispId): mixed
    {
        $storedTarrifCodes = NanguSubscription::forIsp($ispId)->isBilling()->distinct()->get('tariffCode');
        $tarrifCodes = [];
        foreach ($storedTarrifCodes as $tarrifCode) {
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
            if ($channel = NanguSubscription::forIsp($ispId)
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

    protected function channelsTaxesIfIsOfferIncluded(int $ispId, string $tarrifCode): int|float
    {
        $tax = 0;

        $channelsTaxes = GeniusTVchannelsTax::with('channel', 'currency_name')->get();

        foreach ($channelsTaxes as $channelTax) {
            // channel exist
            if ($channel = NanguSubscription::forIsp($ispId)
                ->isBilling()
                ->tarrifCode($tarrifCode)
                ->hasChannel($channelTax->channel->nangu_channel_code)
                ->first()
            ) {
                $explodedOffers = explode(',', $channel->offers);
                foreach ($explodedOffers as $offer) {
                    $offerTax = GeniusTVChannelsOffersTax::whereOffer($offer)->first();
                    if ($offerTax) {
                        $channelsInOffer = Channel::find(json_decode($offerTax->channels_id));
                        foreach ($channelsInOffer as $channelInOffer) {
                            if ($channelInOffer->nangu_channel_code != $channelTax->nangu_channel_code) { // @phpstan-ignore-line
                                $tax = $this->calc_tax(tax: $tax, model: $channelTax);
                            }
                        }
                    }
                }
            }
        }

        return $tax;
    }

    protected function channelPackagesTaxes(int $ispId, string $tarrifCode): int
    {
        $tax = 0;

        foreach (GeniusTVchannelPackagesTax::with('currency_name')->get() as $channelPackage) {
            $channelsInPackage = Channel::find(json_decode($channelPackage->channels_id));
            // exception dont exists
            if (blank($channelPackage->exception)) {
                // count tax for all channels must be in channel package
                if ($channelPackage->must_contains_all == true) {
                    $tax = (float) $tax + (float) $this->count_channel_package_tax_for_all_channels_without_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage);
                } else {
                    // count if contains only one channel
                    $tax = (float) $tax + (float) $this->count_channel_package_tax_for_channels_without_exception($channelsInPackage, $ispId, $tarrifCode, $channelPackage);
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

            echo $tarrifCode . '  ' . $tax . PHP_EOL;
        }

        return $tax;
    }

    protected function offerTaxes(int $ispId, string $tarrifCode): int
    {
        $tax = 0;
        foreach (GeniusTVChannelsOffersTax::with('currency_name')->get() as $geniustvOffer) {
            $numberOfActiveSubscriptionInOffer = NanguSubscription::forIsp($ispId)->isBilling()->offerCode($geniustvOffer->offer)->tarrifCode($tarrifCode)->count();
            if ($numberOfActiveSubscriptionInOffer != 0) {
                $tax = $this->calc_tax_with_number_of_customers($tax, $geniustvOffer, $numberOfActiveSubscriptionInOffer);
            }
        }

        return $tax;
    }

    private function count_channel_package_tax_for_all_channels_without_exception(mixed $channelsInPackage, int $ispId, string $tarrifCode, object $channelPackage): int|float
    {
        $tax = 0;
        $arrayOfSearcheableChannelCodes = [];
        $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->first();
        $explodedOffers = explode(',', $subscriptionInTarrif->offers);

        foreach ($channelsInPackage as $channelInPackage) {
            foreach ($explodedOffers as $offer) {
                $offer = GeniusTVChannelsOffersTax::whereOffer($offer)->first();
                if ($offer) {
                    $channelsInOffer = Channel::find(json_decode($offer->channels_id));
                    foreach ($channelsInOffer as $channelInOffer) {
                        if ($channelInOffer->nangu_channel_code != $channelInPackage->nangu_channel_code) {
                            array_push($arrayOfSearcheableChannelCodes, $channelInPackage->nangu_channel_code);
                        }
                    }
                } else {
                    array_push($arrayOfSearcheableChannelCodes, $channelInPackage->nangu_channel_code);
                }
            }
        }

        if (! blank($arrayOfSearcheableChannelCodes)) {
            // dd(array_unique($arrayOfSearcheableChannelCodes));
            if (Str::containsAll($subscriptionInTarrif->channels, array_unique($arrayOfSearcheableChannelCodes))) {
                $tax = $this->calc_tax(tax: $tax, model: $channelPackage);
            }
        }

        return $tax;
    }

    private function count_channel_package_tax_for_channels_without_exception(mixed $channelsInPackage, int $ispId, string $tarrifCode, object $channelPackage): int|float
    {
        $tax = 0;
        foreach ($channelsInPackage as $channelInPackage) {
            $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->hasChannel($channelInPackage->nangu_channel_code)->first();
            if ($subscriptionInTarrif) {
                $explodedOffers = explode(',', $subscriptionInTarrif->offers);
                foreach ($explodedOffers as $offer) {
                    $offer = GeniusTVChannelsOffersTax::whereOffer($offer)->first();
                    if ($offer) {
                        $channelsInOffer = Channel::find(json_decode($offer->channels_id));
                        foreach ($channelsInOffer as $channelInOffer) {
                            if ($channelInOffer->nangu_channel_code != $channelInPackage->nangu_channel_code) {
                                $tax = $this->calc_tax(tax: $tax, model: $channelPackage);

                                return $tax;
                            }
                        }
                    }
                }

                if (Str::contains($subscriptionInTarrif->channels, $channelInPackage->nangu_channel_code)) {
                    echo $channelInPackage->nangu_channel_code . PHP_EOL;
                    $tax = $this->calc_tax(tax: $tax, model: $channelPackage);
                    break;
                }
            }
        }
        echo $tarrifCode . ' ' . $tax . PHP_EOL;

        return $tax;
    }

    private function count_channel_package_tax_for_all_channels_with_exception(mixed $channelsInPackage, int $ispId, string $tarrifCode, object $channelPackage, array $arrayOfExceptions): int|float
    {
        $tax = 0;
        $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->first();
        if ($subscriptionInTarrif) {
            if (Str::containsAll($subscriptionInTarrif->channels, $channelsInPackage) && ! Str::containsAll($subscriptionInTarrif->channels, $arrayOfExceptions)) {
                $tax = $this->calc_tax(tax: $tax, model: $channelPackage);
            }
        }

        return $tax;
    }

    private function count_channel_package_tax_for_channels_with_exception(mixed $channelsInPackage, int $ispId, string $tarrifCode, object $channelPackage, array $arrayOfExceptions): int|float
    {
        $tax = 0;
        foreach ($channelsInPackage as $channelInPackage) {

            $subscriptionInTarrif = NanguSubscription::forIsp($ispId)->isBilling()->tarrifCode($tarrifCode)->first();
            if ($subscriptionInTarrif) {
                if (Str::contains($subscriptionInTarrif->channels, $channelInPackage) && ! Str::containsAll($subscriptionInTarrif->channels, $arrayOfExceptions)) {
                    $tax = $this->calc_tax(tax: $tax, model: $channelPackage);
                }

                return $tax;
            }
        }

        return $tax;
    }

    private function count_cinematography_fund(int|float $priceForAllChannels): int|float
    {
        // info has Lada Ruzicka
        $const = $priceForAllChannels / 101;
        $priceForAny = $const * 100;
        return $priceForAny * 0.01;
    }
}
