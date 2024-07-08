<?php

namespace App\Services\Api\Adminus;

use App\Traits\Api\RequestTypeTrait;
use Illuminate\Support\Facades\Http;

class ConnectService
{
    use RequestTypeTrait;

    public function create_invoice($contractId, $price): void
    {
        Http
            ::withBasicAuth(config('services.api.adminus.username'), config('services.api.adminus.password'))
            ->post(config('services.api.adminus.url') . str_replace('%contractId%', $contractId, 'v1/adminus-grape/invoice-rule/create/%contractId%'), [
                [
                    "amount" => 1,
                    "unit_untaxed_price" => (float) $price,
                    "description" => "Pronájem IPTV včetně poskytnutých IPTV služeb za období " . now()->subMonth()->format("m/Y"),
                    "source" => "genius-tv-partner-billing"
                ]
            ]);
    }
}
