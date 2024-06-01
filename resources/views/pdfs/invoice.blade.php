<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div>
        <div class="container mx-auto px-12 py-12">
            {{-- logo --}}
            <div class="mt-6 grid grid-cols-12">
                {{-- img s logem --}}
                <div class="col-span-2">
                    <img class="h-12"
                        src="{{ config('app.url') }}
                    /storage/companyLogos/logo_grapesc.svg"
                        alt="grape_logo">
                </div>
                <div class="col-span-2">
                    <img class="h-12"
                        src="{{ config('app.url') }}
                    /companyLogos/logo_geniustv.png"
                        alt="Geniustv_logo">
                </div>
                <div class="col-span-8"></div>
            </div>
            {{-- grid s informaci o poskytovately a zakazníkovi --}}
            <div class="grid grid-cols-12 gap-4 mt-12">
                <div class="col-span-6 bg-gray-50 rounded-lg">
                    <div class="mx-2 my-2">
                        <p class="font-semibold text-lg">
                            GRAPE SC, a.s.
                        </p>
                        <p class="text-md">
                            IC: 25708783
                        </p>
                        <p class="text-md">
                            DIC: CZ25708783
                        </p>
                    </div>
                </div>
                <div class="col-span-6"></div>
            </div>

            {{-- content --}}
            <div class="mt-24">
                <p class="font-semibold">
                    Celkový počet aktivních služeb: <span class="font-bold">{{ $allActiveSubscriptionCount }}</span>
                </p>
            </div>

            <div class="mt-12">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Tarif
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Počet služeb
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cena za klienta
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cena
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarrifs as $tarrifName => $tarrifData)
                                @if ($tarrifName != 'osaData' && $tarrifName != 'hbogo')
                                    <tr class="bg-white border-b dark:bg-gray-800">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $tarrifName }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $tarrifData['count'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ round($tarrifData['pricePerSubscription'], 2) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ round($tarrifData['cost'], 2) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-12">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Počet lužeb HBO GO
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cena za službu
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cena
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarrifs as $tarrifName => $tarrifData)
                                @if ($tarrifName == 'hbogo')
                                    <tr class="bg-white border-b dark:bg-gray-800">
                                        <td class="px-6 py-4">
                                            {{ $tarrifData['count'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ round($tarrifData['pricePerSubscription'], 2) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ round($tarrifData['cost'], 2) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class=" mt-28">
                <span>
                    Cena celkem:
                    <span class="font-bold">
                        {{ round($sum, 2) }} Kč
                    </span>
                </span>
            </div>
        </div>
    </div>
</body>

</html>
