<div>
    <x-share.cards.base-card title="Celkové využití kanálů">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="dark:!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 md:col-span-3">
                <x-button
                    wire:click='exportChannelsUsageToCsv()'
                    class="btn btn-sm btn-doku-primary mt-2 sm:absolute right-5 sm:right-10">
                    Export do csv
                </x-button>
            </div>
        </div>
        <div class="h-96 overflow-y-auto">
            <x-table :headers="$headers" :rows="$statisticsForAllChannels">
                @scope('cell_amount_last_month', $statsForChannel)
                    {{-- last month --}}
                    @foreach ($statsForChannel['amount'] as $stat)
                        @if ($stat->created_at->format('m y') != now()->format('m y'))
                            {{ $stat->value }}
                        @endif
                    @endforeach
                @endscope

                @scope('cell_amount_this_month', $statsForChannel)
                    {{-- this month --}}
                    @foreach ($statsForChannel['amount'] as $stat)
                        @if ($stat->created_at->format('m y') == now()->format('m y'))
                            {{ $stat->value }}
                        @endif
                    @endforeach
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>
</div>
