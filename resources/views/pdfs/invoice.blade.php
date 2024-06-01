<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Fonts -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body class='container mx-auto mt-6' style="font-family: DejaVu Sans, sans-serif;">
    {{-- logo spolecnosti GRAPE --}}

    <div>
        <img src="http://10.255.255.50/storage/Logo_Grape_pruhledne.png" width="150" height="38">
    </div>

    <div class="container mx-auto mt-6">
        {{-- Hlavicka ISP který fakturuje --}}
        <div>
            <div style="display: inline-block" class="">
                <div class="mt-1 ml-1">
                    <p class="text-xl"> GRAPE SC, a.s.</p>
                    <p class="text-sm ml-1">IC: 25708783 </p>
                    <p class="text-sm ml-1 mb-2">DIC: CZ25708783 </p>
                </div>
            </div>
            {{-- Hlavicka ISP , kteremu se fakturuje --}}
            {{-- <div style="background-color: #F3F4F6; display: inline-block; margin-left: 7rem; border-radius: 15px; width:50%;"
                class="">
                <div class="mt-1 ml-10">
                    <p class="text-xl">{{ $ispName }}</p>
                    <p class="text-sm ml-1">IC: {{ $ispIc }} </p>
                    <p class="text-sm ml-1 mb-2">DIC: {{ $ispDic }}</p>
                </div>
            </div> --}}
        </div>


        <div class="mt-2">
            <p class="text-feft text-sm mt-2">
                <strong>
                    Celkem aktivních služeb:
                </strong>
                {{ $allActiveSubscriptionCount }}
            </p>
        </div>

        {{-- tarify --}}
        <table class="table-fixed border w-full mt-6">
            <thead style="background-color: #F3F4F6">
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
                            <td class="border text-left"><small>{{ $tarrifName }}</small></td>
                            <td class="border text-center"><small>{{ $tarrifData['count'] }}</small></td>
                            <td class="border text-center">
                                <small>{{ round($tarrifData['pricePerSubscription'], 2) }}</small>
                            </td>
                            <td class="border text-center"><small>{{ round($tarrifData['cost'], 2) }} Kč</small></td>
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>

        {{-- hbogo --}}
        <table class="table-fixed border w-full mt-6">
            <thead style="background-color: #F3F4F6">
                <tr>
                    <th class="border"><small>Počet HBO GO služeb</small></th>
                    <th class="border"><small>Cena za jednu službu</small></th>
                    <th class="border"><small>Cena celkem</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tarrifs as $tarrifName => $tarrifData)
                    @if ($tarrifName == 'hbogo')
                        <tr>
                            <td class="border text-center"><small>{{ $hbo_go_pocet['count'] }}</small></td>
                            <td class="border text-center">
                                <small>{{ round($tarrifData['pricePerSubscription'], 2) }}</small>
                            </td>
                            <td class="border text-center"><small>{{ round($tarrifData['cost'], 2) }} Kč</small>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>


        {{-- Cena celkem --}}
        <p class="text-right mt-6 text-base">
            <strong>Celková cena:</strong> {{ round($sum, 2) }} Kč
        </p>

</body>
