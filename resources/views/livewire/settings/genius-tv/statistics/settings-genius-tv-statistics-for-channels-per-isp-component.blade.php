<div>
    <x-share.cards.base-card title="Využití kanálů per poskytovatel">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 md:col-span-3">
                {{--  --}}
            </div>
        </div>
        <div class="h-96 overflow-y-auto">
            <x-table :headers="$headers" :rows="$nanguIsps" with-pagination>
                @scope('cell_actions', $nanguIsp)
                    <x-button wire:click='downloadChannelsMonthlyUsageReport({{ $nanguIsp->id }})' icon="o-arrow-down-circle" class="btn-circle bg-transparent border-none btn-sm text-blue-500" />
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>
</div>
