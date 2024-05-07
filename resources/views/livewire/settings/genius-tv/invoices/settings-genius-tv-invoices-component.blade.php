<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 md:col-span-3">
                <x-input type="month" wire:model.live="selectedDate" min="2024-04" />
            </div>
        </div>
        <div>
            <x-table :headers="$headers" :rows="$invoicesForSelectedDate" with-pagination>
                @scope('cell_actions', $invoiceForSelectedDate)
                    <a target="_blank" href="{{ config('app.url') }}/{{ $invoiceForSelectedDate->path }}">
                        <x-heroicon-o-arrow-down-circle class="size-5 text-blue-500" />
                    </a>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>
</div>
