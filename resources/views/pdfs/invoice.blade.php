<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Fonts -->
    <link href="invoice.css" rel="stylesheet">

    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div>
        {{-- logo spolecnosti GRAPE --}}
        <div class="company_logo">
            <img src="/storage/companyLogos/grapesc.png" width="150" height="38" alt="logo">
        </div>

        {{-- Hlavicka ISP který fakturuje --}}
        <div class="isp_card_container">
            <div class="isp_card">
                <div class="isp_card_body">
                    <p><strong> GRAPE SC, a.s.</strong></p>
                    <p><small>IC: 25708783 </small></p>
                    <p><small>DIC: CZ25708783 </small></p>
                </div>
            </div>
            {{-- Hlavicka ISP , kteremu se fakturuje --}}
            <div style="margin-left: 7rem;" class="isp_card">
                <div class="isp_card_body">
                    <p><strong>{{ $isp->name }}</strong></p>
                    @if (!is_null($isp->ic))
                        <p><small>IC: {{ $isp->ic }} </small></p>
                    @else
                        <p><small>IC:</small></p>
                    @endif
                    @if (!is_null($isp->dic))
                        <p><small>DIC: {{ isp->dic }}</small></p>
                    @else
                        <p><small>DIC:</small></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="active_subscriptions">
            <p>
                <strong>
                    Celkem aktivních služeb:
                </strong>
                {{ $allActiveSubscriptionCount }}
            </p>
        </div>

        <div class="container">
            {{-- tarify --}}
            <table>
                <thead>
                    <tr>
                        <th class="border"><small>Tarif</small></th>
                        <th class="border"><small>Počet</small></th>
                        <th class="border"><small>Cena za klienta</small></th>
                        <th class="border"><small>Cena</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarrifs as $tarrifName => $tarrifData)
                        @if ($tarrifName != 'osaData' && $tarrifName != 'hbogo')
                            <tr>
                                <td><small>{{ $tarrifName }}</small></td>
                                <td><small>{{ $tarrifData['count'] }}</small></td>
                                <td>
                                    <small>{{ round($tarrifData['pricePerSubscription'], 2) }}</small>
                                </td>
                                <td><small>{{ round($tarrifData['cost'], 2) }} Kč</small></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            {{-- hbogo --}}
            <table>
                <thead>
                    <tr>
                        <th><small>Počet HBO GO služeb</small></th>
                        <th><small>Cena za jednu službu</small></th>
                        <th><small>Cena celkem</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarrifs as $tarrifName => $tarrifData)
                        @if ($tarrifName == 'hbogo')
                            <tr>
                                <td><small>{{ $hbo_go_pocet['count'] }}</small></td>
                                <td>
                                    <small>{{ round($tarrifData['pricePerSubscription'], 2) }}</small>
                                </td>
                                <td><small>{{ round($tarrifData['cost'], 2) }} Kč</small>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>



        {{-- Cena celkem --}}
        <h3 class="summary">
            <strong>Celková cena:</strong> {{ round($sum, 2) }} Kč
        </h3>

</body>
