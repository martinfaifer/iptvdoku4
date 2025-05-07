@php
    $lnbs = [
        [
            'id' => '13V',
            'name' => '13V',
        ],
        [
            'id' => '18V',
            'name' => '18V',
        ],
    ];

    $lnbTyps = [
        [
            'id' => 'Quatro',
            'name' => 'Quatro',
        ],
        [
            'id' => 'QUAD',
            'name' => 'QUAD',
        ],
    ];

    $lnbs22 = [
        [
            'id' => 'on',
            'name' => 'on',
        ],
        [
            'id' => 'off',
            'name' => 'off',
        ],
    ];

    $polarizations = [
        [
            'id' => 'vertikální',
            'name' => 'vertikální',
        ],
        [
            'id' => 'horizontální',
            'name' => 'horizontální',
        ],
    ];

    $dvbs = [
        [
            'id' => 'DVB-S',
            'name' => 'DVB-S',
        ],
        [
            'id' => 'DVB-S2',
            'name' => 'DVB-S2',
        ],
        [
            'id' => 'DVB-T',
            'name' => 'DVB-T',
        ],
        [
            'id' => 'DVB-T2',
            'name' => 'DVB-T2',
        ],
    ];

    $inputs = [];
    if (array_key_exists('inputs', $device->template)) {
        foreach ($device->template['inputs'] as $key => $value) {
            $inputs[] = [
                'id' => array_key_exists('Název', $value) ? $value['Název'] : rand(10, 20),
                'name' => array_key_exists('Název', $value) ? $value['Název'] : '',
            ];
        }
    }

    $satelits = App\Models\Device::where(
        'device_category_id',
        App\Models\DeviceCategory::where('name', 'Satelity')->first()->id,
    )->get();

    $satelitCards = App\Models\SatelitCard::get();
@endphp
<div>
    <x-share.cards.base-card title="Šablona zařízení">
        <div>
            <button class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-red-500"
                wire:click='delete' wire:confirm='Opravdu odebrat šablonu?'>
                <x-heroicon-s-trash class="size-4" />
            </button>
        </div>
        @if ($hasCharts)
            <div class="navbar bg-transparent !min-h-4">
                <div class="flex-1">
                </div>
                <div class="flex-none">
                    <button class="btn btn-sm btn-doku-navigation" x-on:click='$wire.loadCharts()'>
                        <x-heroicon-s-chart-bar class="size-4" />
                        Zobrazit grafy</button>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-12 mt-2 bg-transparent rounded-sm">
            <div class="col-span-12 mb-0">
                @if (array_key_exists('snmp', $template))
                    <p class="font-semibold text-center mb-4">
                        Obecné informace o zařízení
                    </p>
                    <div class="grid grid-cols-12 gap-4 mb-4">
                        <div
                            class="col-span-12 dark:bg-[#082F49] rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm shadow-sm dark:shadow-md dark:shadow-slate-900/50">
                            <div class="grid grid-cols-12 gap-4 ml-8">
                                @foreach ($template['snmp'] as $deviceSnmpData)
                                    @if ($deviceSnmpData['type'] == 'read')
                                        <div class="col-span-12 md:col-span-6 xl:col-span-3 my-4 flex font-semibold">
                                            <span class="font-normal">
                                                {{ $deviceSnmpData['human_description'] }} :
                                            </span>
                                            <span class="ml-4">
                                                @if ($deviceSnmpData['human_description'] == 'Uptime')
                                                    @php
                                                        $days = '';
                                                        if (
                                                            $deviceSnmpData['value'] != '' &&
                                                            !str_contains($deviceSnmpData['value'], 'n/a')
                                                        ) {
                                                            $days = \Carbon\CarbonInterval::days(
                                                                $deviceSnmpData['value'] / 8640000,
                                                            )
                                                                ->cascade()
                                                                ->forHumans();
                                                        }

                                                    @endphp
                                                    {{ $days }}
                                                @elseif($deviceSnmpData['human_description'] == 'Log')
                                                    <x-button
                                                        class="btn-circle border-none btn-xs bg-transparent text-sky-500"
                                                        @click="$wire.loadLog('{{ $deviceSnmpData['oid'] }}')">
                                                        <div class="flex">
                                                            <x-icon name="o-newspaper"></x-icon>

                                                            <div wire:loading
                                                                wire:target="loadLog('{{ $deviceSnmpData['oid'] }}')">
                                                                <span class="loading loading-spinner loading-md"></span>
                                                            </div>
                                                        </div>
                                                    </x-button>
                                                @else
                                                    {{ $deviceSnmpData['value'] }}
                                                @endif
                                            </span>
                                        </div>
                                    @else
                                        <div class="col-span-3 my-4 flex font-semibold">
                                            <x-button class="btn-sm btn-doku-navigation !text-red-500"
                                                @click="$wire.restartInterface('{{ $deviceSnmpData['oid'] }}')">
                                                <div class="flex">
                                                    Restart zařízení

                                                    <div wire:loading
                                                        wire:target="restartInterface('{{ $deviceSnmpData['oid'] }}')">
                                                        <span class="loading loading-spinner loading-md"></span>
                                                    </div>
                                                </div>
                                            </x-button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @foreach ($template as $interfaceType => $interfacesData)
                    @if ($interfaceType == 'inputs')
                        <p class="font-semibold
                            text-center mb-4">
                            Vstupy
                        </p>
                        <div class="grid grid-cols-12 gap-4 min-h-20 ">
                            @foreach ($interfacesData as $interfaceKey => $interface)
                                {{-- clickable --}}
                                <div class="col-span-12 md:col-span-6 xl:col-span-3 mb-4 overflow-scroll h-96">
                                    <div
                                        class="bg-slate-800/5 dark:bg-[#082F49] rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm hadow-md shadow-slate-900/50">
                                        <div class="card-body dark:text-gray-200 text-sm cursor-pointer"
                                            @click="$wire.openUpdateDrawer('{{ $interfaceKey }}', 'inputs')">
                                            <div class="grid grid-cols-12 mb-4">
                                                {{-- snmp data --}}
                                                @foreach ($interface as $interfaceValueName => $interfaceValue)
                                                    @if (is_array($interfaceValue) && !empty($interfaceValue))
                                                        @foreach ($interfaceValue as $snmp)
                                                            @if (!empty($snmp['value']))
                                                                <div class="col-span-12 my-4 flex justify-between">
                                                                    <div>
                                                                        {{ $snmp['human_description'] }}:
                                                                    </div>
                                                                    <div @class([
                                                                        'font-semibold',
                                                                        'text-red-500' => $snmp['value'] == 'UNLOCKED',
                                                                        'text-green-500' => $snmp['value'] == 'LOCKED',
                                                                    ])>
                                                                        {{ $snmp['value'] }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                {{-- user define --}}
                                                @foreach ($interface as $interfaceValueName => $interfaceValue)
                                                    @if (is_string($interfaceValue))
                                                        <div class="col-span-12 my-4 flex justify-between">
                                                            <div class="font-semibold">
                                                                {{ $interfaceValueName }} :
                                                            </div>
                                                            <div class="font-semibold">
                                                                @if (!str_contains($interfaceValue, '%'))
                                                                    {{ $interfaceValue }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($interfaceType == 'outputs')
                        <p class="font-semibold text-center mb-4">
                            Výstupy
                        </p>
                        <div class="grid grid-cols-12 gap-4 min-h-20">
                            @foreach ($interfacesData as $interfaceKey => $interface)
                                <div @class([
                                    'mb-4 overflow-scroll col-span-12 md:col-span-6 h-48',
                                    'xl:col-span-2' => count($interfacesData) > 4,
                                    'xl:col-span-3' => count($interfacesData) <= 4,
                                ])>
                                    <div
                                        class="bg-slate-800/5 dark:bg-[#082F49] rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm shadow-md shadow-slate-900/50">
                                        <div class="card-body dark:text-gray-200 text-sm cursor-pointer"
                                            @click="$wire.openUpdateDrawer('{{ $interfaceKey }}', 'outputs')">
                                            <div class="grid grid-cols-12 mb-4">
                                                @foreach ($interface as $interfaceValueName => $interfaceValue)
                                                    @if (is_array($interfaceValue) && !empty($interfaceValue))
                                                        {{-- snmp --}}
                                                        @foreach ($interfaceValue as $snmp)
                                                            @if (is_array($snmp) && array_key_exists('type', $snmp))
                                                                @if ($snmp['type'] == 'write')
                                                                    @if (str_contains($snmp['human_description'], 'reset'))
                                                                        <x-button
                                                                            class="btn btn-sm btn-doku-navigation !text-red-500 w-32 h-4"
                                                                            wire:click="restartInterface('{{ $snmp['oid'] }}')">
                                                                            <div class="flex">
                                                                                <div>
                                                                                    Restart
                                                                                </div>
                                                                                <div wire:loading
                                                                                    wire:target="restartInterface('{{ $snmp['oid'] }}')">
                                                                                    <span
                                                                                        class="loading loading-spinner loading-md"></span>
                                                                                </div>
                                                                            </div>
                                                                        </x-button>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                            @if (is_array($snmp) && array_key_exists('value', $snmp))
                                                                @if ($snmp['value'] != '' && $snmp['value'] != 'n/a')
                                                                    <div class="col-span-12 my-4 flex justify-between">
                                                                        <div>
                                                                            {{ $snmp['human_description'] }}:
                                                                        </div>
                                                                        <div @class([
                                                                            'font-semibold',
                                                                            'text-red-500' => $snmp['value'] == 'UNLOCKED',
                                                                            'text-green-500' => $snmp['value'] == 'LOCKED',
                                                                            'text-red-500' => $snmp['value'] == 'not inserted',
                                                                            'text-green-500' => $snmp['value'] == 'OK',
                                                                        ])>
                                                                            {{ $snmp['value'] }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @foreach ($interface as $interfaceValueName => $interfaceValue)
                                                    @if (is_string($interfaceValue) || is_int($interfaceValue))
                                                        <div class="col-span-12 my-4 flex justify-between">
                                                            <div class="font-semibold">
                                                                {{ $interfaceValueName }} :
                                                            </div>
                                                            <div class="font-semibold">
                                                                @if ($interfaceValueName == 'Vazba na satelit')
                                                                    @php
                                                                        if (is_int($interfaceValue)) {
                                                                            $device = App\Models\Device::find(
                                                                                $interfaceValue,
                                                                            );
                                                                            if ($device) {
                                                                                $interfaceValue = $device->name;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                @endif

                                                                @if ($interfaceValueName == 'Satelitní karta')
                                                                    @php
                                                                        if (is_int($interfaceValue)) {
                                                                            $card = App\Models\SatelitCard::find(
                                                                                $interfaceValue,
                                                                            );
                                                                            if ($card) {
                                                                                $interfaceValue = $card->name;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                @endif
                                                                @if (!str_contains($interfaceValue, '%'))
                                                                    {{ $interfaceValue }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($interfaceValueName, 'nested'))
                                                        @foreach ($interfaceValue as $nestedItem)
                                                            <div class="col-span-12 my-4 flex justify-between">
                                                                <div class="font-semibold">
                                                                    {{ $nestedItem['human_description'] }}:
                                                                </div>
                                                                <div class="font-semibold">
                                                                    {{ $nestedItem['replace'] }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($interfaceType == 'modules')
                        <p class="font-semibold text-center mb-4">
                            Moduly
                        </p>
                        <div class="grid grid-cols-12 gap-4 min-h-20 h-[320px]">
                            @foreach ($interfacesData as $interfaceKey => $interface)
                                <div class="col-span-3 mb-4 overflow-scroll">
                                    <div
                                        class="bg-slate-800/5 dark:bg-[#082F49]
                         rounded-lg
                         bg-clip-padding
                         backdrop-filter
                         backdrop-blur-sm
                         shadow-md
                         shadow-slate-900/50">
                                        <div class="card-body dark:text-gray-200 text-sm cursor-pointer"
                                            @click="$wire.openUpdateDrawer('{{ $interfaceKey }}', 'modules')">
                                            <div class="grid grid-cols-12 mb-4">
                                                @foreach ($interface as $interfaceValueName => $interfaceValue)
                                                    @if (is_string($interfaceValue))
                                                        <div class="col-span-12 my-4 flex justify-between">
                                                            <div class="font-semibold">
                                                                {{ $interfaceValueName }} :
                                                            </div>
                                                            <div class="font-semibold">
                                                                @if (!str_contains($interfaceValue, '%'))
                                                                    {{ $interfaceValue }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </x-share.cards.base-card>

    <x-drawer wire:model="updateDrawer" right class="lg:w-1/3 !dark:bg-[#0E1E33]">
        <x-form wire:submit="update">
            <div class="grid grid-cols-12 mt-12 rounded-sm">
                <div class="col-span-12 mb-4">
                    <div class="mx-4 mt-4">
                        @foreach ($updatedInterface as $name => $value)
                            @if (str_contains($name, 'nested'))
                                @foreach ($value as $nestedItemKey => $nestedItem)
                                    <div class="mb-4">
                                        <x-input label="{{ $nestedItem['human_description'] }}"
                                            wire:model.live="updatedInterface.{{ $name }}.{{ $nestedItemKey }}.replace"></x-input>
                                    </div>
                                @endforeach
                            @endif
                            <div class="mb-4">
                                @if ($name == 'Název')
                                    <x-input label="{{ $name }}"
                                        wire:model.live="updatedInterface.{{ $name }}"></x-input>
                                @endif

                                @if ($name == 'Průměr paraboly')
                                    <x-input label="{{ $name }}"
                                        wire:model.live="updatedInterface.{{ $name }}"></x-input>
                                @endif

                                @if ($name == 'Frekvence')
                                    <x-input label="{{ $name }}"
                                        wire:model.live="updatedInterface.{{ $name }}"
                                        type="number"></x-input>
                                @endif

                                @if ($name == 'DVB')
                                    <x-choices label="{{ $name }}" :options="$dvbs"
                                        wire:model.live="updatedInterface.{{ $name }}" single />
                                @endif

                                @if ($name == 'Satelit')
                                    <x-choices label="{{ $name }}" :options="$satelits"
                                        wire:model.live="updatedInterface.{{ $name }}" single />
                                @endif

                                @if ($name == 'Polarizace')
                                    <x-choices label="{{ $name }}" :options="$polarizations"
                                        wire:model.live="updatedInterface.{{ $name }}" single />
                                @endif

                                @if ($name == 'Symbol rate')
                                    <x-input label="{{ $name }}"
                                        wire:model.live="updatedInterface.{{ $name }}"
                                        type="number"></x-input>
                                @endif

                                @if ($name == 'FEC')
                                    <x-input label="{{ $name }}"
                                        wire:model.live="updatedInterface.{{ $name }}"></x-input>
                                @endif

                                @if ($name == 'LNB')
                                    <x-choices label="LNB" :options="$lnbs"
                                        wire:model.live="updatedInterface.{{ $name }}" single />
                                @endif

                                @if ($name == 'LNB22KV')
                                    <x-choices label="LNB22KV" :options="$lnbs22"
                                        wire:model.live="updatedInterface.{{ $name }}" single />
                                @endif

                                @if ($name == 'Vazba na vstupní interface')
                                    <x-choices label="Vstupní interface" :options="$inputs"
                                        wire:model.live="updatedInterface.{{ $name }}" single />
                                @endif

                                @if ($name == 'LNB typ')
                                    <x-choices label="{{ $name }}" :options="$lnbTyps"
                                        wire:model.live="updatedInterface.{{ $name }}" single />
                                @endif

                                @if ($name == 'Vazba na satelit')
                                    <x-choices-offline label="{{ $name }}" :options="$satelits"
                                        wire:model.live="updatedInterface.{{ $name }}" single searchable />
                                @endif

                                @if ($name == 'Satelitní karta')
                                    <x-choices-offline label="{{ $name }}" :options="$satelitCards"
                                        wire:model.live="updatedInterface.{{ $name }}" single searchable />
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 mt-6">
                <div class="col-span-12 mb-4">
                    <x-form wire:submit="store">
                        <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                            wire:click='closeDrawer'>✕</x-button>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6 mb-4">
                                {{--  --}}
                            </div>
                        </div>

                        {{-- action section --}}
                        <div class="flex justify-between">
                            <div>
                                <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                                    wire:click='closeDrawer' />
                            </div>
                            <div>
                                <x-button label="Upravit" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                                    spinner="store" />
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </x-form>
    </x-drawer>

    {{-- modal log --}}
    <x-modal wire:model="logModal" title="Log ze zařízení" persistent class="modal-bottom sm:modal-middle fixed"
        box-class="!max-w-6xl">

        <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
            @click='$wire.closeDialog'>✕</x-button>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <input wire:model.live='search' type="text" placeholder="Vyhledejte ..."
                    class="input input-bordered bg-opacity-20 text-white placeholder:text-xs w-full md:w-96 mb-4" />
            </div>
            <div class="col-span-12 mb-4 overflow-y-auto h-96">
                <ul x-auto-animate>
                    @if (!in_array('n/a', $logs))
                        @foreach ($logs as $log)
                            @if (blank($search))
                                <li @class([
                                    'font-semibold',
                                    'text-red-500' => str_contains($log, 'down'),
                                    'text-red-500' => str_contains($log, 'unlocked'),
                                    'text-red-500' => str_contains($log, 'high'),
                                ])>
                                    {{ $log }}
                                </li>
                            @elseif (str_contains(strtolower($log), strtolower($search)))
                                <li @class([
                                    'font-semibold',
                                    'text-red-500' => str_contains($log, 'down'),
                                    'text-red-500' => str_contains($log, 'unlocked'),
                                    'text-red-500' => str_contains($log, 'high'),
                                ])>
                                    {{ $log }}
                                </li>
                            @endif
                        @endforeach
                    @else
                        <x-share.alerts.info title="Nepodařilo se načíst logy"></x-share.alerts.info>
                    @endif
                </ul>
            </div>
        </div>

        {{-- action section --}}
        <div class="flex justify-between">
            <div>
            </div>
            <div>
                <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" @click='$wire.closeDialog' />
            </div>
        </div>

    </x-modal>

    {{-- modal charts --}}
    <x-modal wire:model="chartModal" title="" persistent class="modal-bottom sm:modal-middle fixed"
        box-class="!max-w-6xl">

        <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
            @click='$wire.closeDialog'>✕</x-button>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-4 overflow-y-auto h-96">
                @foreach ($charts as $chartKey => $chart)
                    <div class="col-span-12 md:col-span-6 mb-4" wire:key='chart_{{ $chartKey }}'>
                        @php
                            $exploded = explode(':', $chartKey);
                            $label = $exploded[2];
                        @endphp
                        <livewire:charts.line-chart-component :xaxis="$chart[0]['xaxis']" :yaxis="$chart[0]['yaxis']" :label="$label">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- action section --}}
        <div class="flex justify-between">
            <div>
            </div>
            <div>
                <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" @click='$wire.closeDialog' />
            </div>
        </div>

    </x-modal>
</div>
