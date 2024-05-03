@php
    $newestWikiTopicsHeader = [
        ['key' => 'title', 'label' => 'Titulek', 'class' => 'text-white/80'],
        ['key' => 'creator', 'label' => 'Autor', 'class' => 'text-white/80'],
    ];
    $newestUsersHeader = [['key' => 'email', 'label' => 'Email', 'class' => 'text-white/80']];
    $passedEventsHeader = [
        ['key' => 'label', 'label' => 'Titulek', 'class' => 'text-white/80'],
        ['key' => 'creator', 'label' => 'Autor', 'class' => 'text-white/80'],
    ];
@endphp
<div>
    <div class="grid grid-cols-12 gap-2">
        <div class="col-span-12 md:col-span-2">
            <x-stat class="!bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50" title="Kanály"
                value="{{ $channels }}" icon="o-tv" color="text-[#A6ADBB]" tooltip="Celkové množství kanálů" />
        </div>
        <div class="col-span-12 md:col-span-2">
            <x-stat class="!bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50" title="H264"
                value="{{ $h264s }}" icon="o-tv" color="text-[#A6ADBB]" tooltip="Celkové množství H264" />
        </div>
        <div class="col-span-12 md:col-span-2">
            <x-stat class="!bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50" title="H265"
                value="{{ $h265s }}" icon="o-tv" color="text-[#A6ADBB]" tooltip="Celkové množství H265" />
        </div>
        <div class="col-span-12 md:col-span-2">
            <x-stat class="!bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50" title="Zařízení"
                value="{{ $devices }}" icon="o-device-tablet" color="text-[#A6ADBB]"
                tooltip="Celkové množství zařízeních" />
        </div>
        <div class="col-span-12 md:col-span-2">
            <x-stat class="!bg-[#0f172a]/50 !backdrop-blur-xl !shadow-md !shadow-[#0D243C]/50" title="Karty"
                value="{{ $satCards }}" icon="o-credit-card" color="text-[#A6ADBB]"
                tooltip="Celkové množství satelitních karet" />
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 mt-8">
        {{-- nejnovější články na wiki --}}
        <div class="col-span-12 md:col-span-4">
            <x-share.cards.base-card title="Nejnovější články wiki">
                <div class=" h-48 overflow-auto">
                    <x-table :headers="$newestWikiTopicsHeader" :rows="$newestTopics" />
                </div>
            </x-share.cards.base-card>
        </div>
        {{-- nejnovější uživatelé --}}
        <div class="col-span-12 md:col-span-4">
            <x-share.cards.base-card title="Nejnovější uživatelé">
                <div class=" h-48 overflow-auto">
                    <x-table :headers="$newestUsersHeader" :rows="$newestUsers" />
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
