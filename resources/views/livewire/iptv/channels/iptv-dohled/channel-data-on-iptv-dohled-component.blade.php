<div>
    @if (!is_null($channelDataOnIptvDohled))
        <div class="flex mb-4">
            <hr
                class="w-1/2 h-[1px] mt-2 mr-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
            <span class="text-xs italic text-center">Informace z dohledu o {{ $ip }}</span>
            <hr
                class="w-1/2 h-[1px] mt-2 ml-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
        </div>
        <x-share.cards.base-card title="Informace z dohledu o {{ $ip }}">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 sm:col-span-3">
                    <img src="{{ $channelDataOnIptvDohled['data']['img'] }}" alt="dohled_img"
                        class="object-cover h-48 w-96 rounded-md" />
                </div>
                <div class="col-span-12 sm:col-span-9">
                    <div class="grid grid-cols-12 gap-4">
                        {{-- common informartion about stream from dohled --}}
                        <div class="col-span-12 sm:col-span-4">
                            <p class="text-center font-semibold">
                                Obecné informace
                            </p>
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-1">
                                    <x-share.lines.vertical-small-hr></x-share.lines.vertical-small-hr>
                                </div>
                                <div class="col-span-11">
                                    <div class="grid grid-rows-5 gap-4 mt-4 text-sm font-semibold">
                                        <div>
                                            <span>
                                                Status:
                                            </span>
                                            @if ($channelDataOnIptvDohled['data']['streamStatus'] == 'monitoring')
                                                <span class="text-green-500 font-semibold">
                                                    Dohleduje se
                                                </span>
                                            @endif
                                            @if ($channelDataOnIptvDohled['data']['streamStatus'] == 'can_not_start')
                                                <span class="text-red-500 font-semibold">
                                                    Výpadek
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <span>
                                                Dohledováno od:
                                            </span>
                                            <span class="font-semibold">
                                                {{ $channelDataOnIptvDohled['data']['monitored_at'] }}
                                            </span>
                                        </div>
                                        <div>
                                            <a class="font-semibol text-blue-500 hover:underline"
                                                href="https://iptvdohled.grapesc.cz/#/stream/{{ $channelDataOnIptvDohled['data']['streamId'] }}"
                                                target="_blank"> Proklik na stream</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-4 gap-4">
                            <p class="text-center font-semibold">
                                Informace o servisách ve streamu
                            </p>
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-1">
                                    <x-share.lines.vertical-small-hr></x-share.lines.vertical-small-hr>
                                </div>
                                <div class="col-span-11">
                                    <div class="grid grid-rows-5 gap-4 mt-4 text-sm font-semibold" >
                                        <div>
                                            TSID: {{ $channelDataOnIptvDohled['data']['streamTS']['tsid'] }}
                                        </div>
                                        <div>
                                            PMT Pid: {{ $channelDataOnIptvDohled['data']['streamTS']['pmtpid'] }}
                                        </div>
                                        <div>
                                            PCR Pid: {{ $channelDataOnIptvDohled['data']['streamTS']['pcrpid'] }}
                                        </div>
                                        <div>
                                            Provider: {{ $channelDataOnIptvDohled['data']['streamTS']['provider'] }}
                                        </div>
                                        <div>
                                            Name: {{ $channelDataOnIptvDohled['data']['streamTS']['name'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- history of stream --}}
                        <div class="col-span-12 sm:col-span-4">
                            <p class="text-center font-semibold">
                                Historie
                            </p>
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-1">
                                    <x-share.lines.vertical-small-hr></x-share.lines.vertical-small-hr>
                                </div>
                                <div class="col-span-11">
                                    <div class="overflow-x-auto">
                                        <table class="table table-sm">
                                            <!-- head -->
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fixed h-44 overflow-y-auto">
                                                @foreach ($channelDataOnIptvDohled['data']['history'] as $history)
                                                    <tr>
                                                        <th>
                                                            @if ($history['status'] == 'monitoring')
                                                                <span class="text-green-500">
                                                                    Dohleduje se
                                                                </span>
                                                            @endif
                                                            @if ($history['status'] == 'can_not_start')
                                                                <span class="text-red-500">
                                                                    Výpadek
                                                                </span>
                                                            @endif
                                                        </th>
                                                        <td>{{ $history['created_at'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12">
                    <x-share.lines.visible-small-hr></x-share.lines.visible-small-hr>
                    <div class="mt-2">
                        <p class="text-center font-semibold">
                            Informace o audiu
                        </p>
                        <div class="grid grid-cols-12 gap-4 mt-2">
                            @foreach ($channelDataOnIptvDohled['data']['audioPids'] as $audioPid)
                                <div class="col-span-2">
                                    <span>
                                        Pid:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $audioPid['pid'] }}
                                    </span>
                                </div>
                                <div class="col-span-2">
                                    <span>
                                        Datový tok:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $audioPid['bitrate'] }}
                                    </span>
                                </div>
                                <div class="col-span-2">
                                    <span>
                                        Scrambled:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $audioPid['scrambled'] }}
                                    </span>
                                </div>
                                <div class="col-span-2">
                                    <span>
                                        Discontinuity:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $audioPid['discontinuities'] }}
                                    </span>
                                </div>
                                <div class="col-span-4">
                                    <span class="">
                                        Popis:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $audioPid['description'] }}
                                    </span>
                                </div>
                                {{-- description --}}
                            @endforeach
                        </div>
                        <div class="grid grid-cols-12 gap-4 mt-2">
                            @foreach ($channelDataOnIptvDohled['data']['audioCharts'] as $audioChart)
                                <div class="col-span-4">
                                    <livewire:charts.line-chart-component :xaxis="$audioChart['xaxis']" :yaxis="$audioChart['seriesData']"
                                        label="Datový tok v Mbps">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-span-12">
                    <x-share.lines.visible-small-hr></x-share.lines.visible-small-hr>
                    <div class="mt-2">
                        <p class="text-center font-semibold">
                            Informace o videu
                        </p>
                        <div class="grid grid-cols-12 gap-4 mt-2">
                            @foreach ($channelDataOnIptvDohled['data']['videoPids'] as $videoPid)
                                <div class="col-span-2">
                                    <span>
                                        Pid:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $videoPid['pid'] }}
                                    </span>
                                </div>
                                <div class="col-span-2">
                                    <span>
                                        Datový tok:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $videoPid['bitrate'] }}
                                    </span>
                                </div>
                                <div class="col-span-2">
                                    <span>
                                        Scrambled:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $videoPid['is-scrambled'] }}
                                    </span>
                                </div>
                                <div class="col-span-2">
                                    <span>
                                        Discontinuity:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $videoPid['discontinuities'] }}
                                    </span>
                                </div>
                                <div class="col-span-4">
                                    <span class="">
                                        Popis:
                                    </span>
                                    <span class="ml-2 font-semibold">
                                        {{ $audioPid['description'] }}
                                    </span>
                                </div>
                                {{-- description --}}
                            @endforeach
                        </div>
                        <div class="grid grid-cols-12 gap-4 mt-2">
                            @foreach ($channelDataOnIptvDohled['data']['videoCharts'] as $videoChart)
                                <div class="col-span-4">
                                    <livewire:charts.line-chart-component :xaxis="$videoChart['xaxis']" :yaxis="$videoChart['seriesData']"
                                        label="Datový tok v Mbps" wire:poll.30s>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-share.cards.base-card>
    @endif
</div>
