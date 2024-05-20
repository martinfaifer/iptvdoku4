@php
    $newestWikiTopicsHeader = [
        ['key' => 'title', 'label' => 'Titulek', 'class' => 'text-white/80'],
        ['key' => 'creator', 'label' => 'Autor', 'class' => 'text-white/80'],
    ];
    $newestUsersHeader = [
        ['key' => 'avatar', 'label' => ''],
        ['key' => 'email', 'label' => 'Email', 'class' => 'text-white/80'],
        ['key' => 'userRole.name', 'label' => 'Role', 'class' => 'text-white/80'],
    ];
    $passedEventsHeader = [
        ['key' => 'label', 'label' => 'Titulek', 'class' => 'text-white/80'],
        ['key' => 'creator', 'label' => 'Autor', 'class' => 'text-white/80'],
    ];
@endphp
<div>
    <div class="grid grid-cols-12 gap-2">
        <div class="col-span-12 md:col-span-2">
            <div
                class="rounded-lg px-5 py-4  w-full lg:tooltip lg:tooltip-top !bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50">
                <div class="flex items-center gap-4">
                    <div class="  text-[#A6ADBB]">
                        <x-heroicon-o-tv class="size-9 inline" />
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-500 whitespace-nowrap">Kanály</div>
                        <div class="font-black text-xl text-[#A6ADBB]">{{ $channels }}</div>
                    </div>
                    <div class="right-2 fixed">
                        <x-button class="bg-transparent hover:bg-[#0A2941] text-white w-full md:w-auto"
                            wire:click="export_channels">
                            <x-heroicon-o-arrow-down-tray class="size-4 inline" />
                            <div wire:loading wire:target="export_channels">
                                <span class="loading loading-spinner loading-md"></span>
                            </div>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-2">
            <div
                class="rounded-lg px-5 py-4  w-full lg:tooltip lg:tooltip-top !bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50">

                <div class="flex items-center gap-4">
                    <div class="  text-[#A6ADBB]">
                        <x-heroicon-o-tv class="size-9 inline" />
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-500 whitespace-nowrap">Multicasty</div>
                        <div class="font-black text-xl text-[#A6ADBB]">{{ $multicasts }}</div>
                    </div>
                    <div class="right-2 fixed">
                        <x-button class="bg-transparent hover:bg-[#0A2941] text-white w-full md:w-auto"
                            wire:click="export_multicasts">
                            <x-heroicon-o-arrow-down-tray class="size-4 inline" />
                            <div wire:loading wire:target="export_multicasts">
                                <span class="loading loading-spinner loading-md"></span>
                            </div>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-2">
            <div
                class="rounded-lg px-5 py-4  w-full lg:tooltip lg:tooltip-top !bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50">
                <div class="flex items-center gap-4">
                    <div class="  text-[#A6ADBB]">
                        <x-heroicon-o-tv class="size-9 inline" />
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-500 whitespace-nowrap">H264</div>
                        <div class="font-black text-xl text-[#A6ADBB]">{{ $h264s }}</div>
                    </div>
                    <div class="right-2 fixed">
                        <x-button class="bg-transparent hover:bg-[#0A2941] text-white w-full md:w-auto"
                            wire:click="export_h264s">
                            <x-heroicon-o-arrow-down-tray class="size-4 inline" />
                            <div wire:loading wire:target="export_h264s">
                                <span class="loading loading-spinner loading-md"></span>
                            </div>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-2">
            <div
                class="rounded-lg px-5 py-4  w-full lg:tooltip lg:tooltip-top !bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50">
                <div class="flex items-center gap-4">
                    <div class="  text-[#A6ADBB]">
                        <x-heroicon-o-tv class="size-9 inline" />
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-500 whitespace-nowrap">H265</div>
                        <div class="font-black text-xl text-[#A6ADBB]">{{ $h265s }}</div>
                    </div>
                    <div class="right-2 fixed">
                        <x-button class="bg-transparent hover:bg-[#0A2941] text-white w-full md:w-auto"
                            wire:click="export_h265s">
                            <x-heroicon-o-arrow-down-tray class="size-4 inline" />
                            <div wire:loading wire:target="export_h265s">
                                <span class="loading loading-spinner loading-md"></span>
                            </div>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-2">
            <div
                class="rounded-lg px-5 py-4  w-full lg:tooltip lg:tooltip-top !bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50">
                <div class="flex items-center gap-4">
                    <div class="  text-[#A6ADBB]">
                        <x-heroicon-o-tv class="size-9 inline" />
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-500 whitespace-nowrap">Zařízení</div>
                        <div class="font-black text-xl text-[#A6ADBB]">{{ $devices }}</div>
                    </div>
                    <div class="right-2 fixed">
                        <x-button class="bg-transparent hover:bg-[#0A2941] text-white w-full md:w-auto"
                            wire:click="export_devices">
                            <x-heroicon-o-arrow-down-tray class="size-4 inline" />
                            <div wire:loading wire:target="export_devices">
                                <span class="loading loading-spinner loading-md"></span>
                            </div>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-2">
            <div
                class="rounded-lg px-5 py-4  w-full lg:tooltip lg:tooltip-top !bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50">
                <div class="flex items-center gap-4">
                    <div class="  text-[#A6ADBB]">
                        <x-heroicon-o-tv class="size-9 inline" />
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-gray-500 whitespace-nowrap">Karty</div>
                        <div class="font-black text-xl text-[#A6ADBB]">{{ $satCards }}</div>
                    </div>
                    <div class="right-2 fixed">
                        <x-button class="bg-transparent hover:bg-[#0A2941] text-white w-full md:w-auto"
                            wire:click="export_sat_cards">
                            <x-heroicon-o-arrow-down-tray class="size-4 inline" />
                            <div wire:loading wire:target="export_sat_cards">
                                <span class="loading loading-spinner loading-md"></span>
                            </div>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 mt-8">
        {{-- nejnovější články na wiki --}}
        <div class="col-span-12 md:col-span-4">
            <x-share.cards.base-card title="Nejnovější články wiki">
                <div class=" h-48 overflow-auto">
                    <x-table :headers="$newestWikiTopicsHeader" :rows="$newestTopics">
                        @scope('cell_title', $topic)
                            <a class="text-[#226393] hover:underline" href="/wiki/{{ $topic->id }}"
                                wire:navigate>{{ $topic->title }}</a>
                        @endscope
                    </x-table>
                </div>
            </x-share.cards.base-card>
        </div>
        {{-- nejnovější uživatelé --}}
        <div class="col-span-12 md:col-span-4">
            <x-share.cards.base-card title="Nejnovější uživatelé">
                <div class="h-48 overflow-auto">
                    <x-table :headers="$newestUsersHeader" :rows="$newestUsers">
                        @scope('cell_avatar', $newestUser)
                            <div class="rounded-full size-8 bg-black flex items-center justify-center cursor-pointer">
                                @if (is_null($newestUser->avatar_url))
                                    <div class="font-semibold">
                                        {{ $newestUser->first_name[0] }}
                                        {{ $newestUser->last_name[0] }}
                                    </div>
                                @else
                                    <img class="object-contain rounded-full" src="{{ config('app.url')."/". $newestUser->avatar_url }}"
                                        alt="" />
                                @endif
                            </div>
                        @endscope
                    </x-table>
                </div>
            </x-share.cards.base-card>
        </div>
        {{-- proběhlé události --}}
        <div class="col-span-12 md:col-span-4">
            <x-share.cards.base-card title="Proběhlé události">
                <div class=" h-48 overflow-auto">
                    <x-table :headers="$passedEventsHeader" :rows="$passedEvents" />
                </div>
            </x-share.cards.base-card>
        </div>
    </div>


    <div class="grid grid-cols-12 gap-4 mt-8">
        {{-- dropdown for nanguIsps --}}
        <div class="col-span-12 ">
            <div class="navbar bg-transparent">
                <div class="flex-1">
                </div>
                <div class="md:flex-none gap-2 md:overflow-x-auto">
                    <div class="right-2">
                        <x-select label="Vyberte poskytovatele GeniusTV" wire:model.live="nanguIsp" :options="$nanguIsps"
                            wire:change="$dispatch('reload_new_nangu_isp_charts')" single />
                    </div>
                </div>
            </div>
        </div>
        {{-- subscriptions chart --}}
        <div class="col-span-12 md:col-span-6">
            <x-share.cards.base-card title="">
                <livewire:charts.line-chart-component :xaxis="$subscriptionsChartData['labels']" :yaxis="$subscriptionsChartData['data']"
                    label="Počet služeb"></livewire:charts.line-chart-component>
            </x-share.cards.base-card>
        </div>
        {{-- stbs chart --}}
        <div class="col-span-12 md:col-span-6">
            {{-- <x-share.cards.base-card title="">

            </x-share.cards.base-card> --}}
        </div>
    </div>
</div>
