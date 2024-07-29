<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query" class="input-md placeholder:text-gray-600"
                    icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 md:col-span-3">
                {{--  --}}
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$logs" with-pagination :sort-by="$sortBy">
                @scope('cell_type', $log)
                    @if ($log->type == 'created')
                        <span class="text-green-500 font-semibold italic">Vytvořeno</span>
                    @endif
                    @if ($log->type == 'updated')
                        <span class="text-blue-500 font-semibold italic">Upraveno</span>
                    @endif
                    @if ($log->type == 'deleted')
                        <span class="text-red-500 font-semibold italic">Odebráno</span>
                    @endif
                @endscope

                @scope('cell_actions', $log)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            x-on:click="$wire.show({{ $log->payload }} , {{ $log->id }})">
                            <x-heroicon-o-magnifying-glass class="size-4 text-blue-500" />
                        </button>
                    </div>
                @endscope

                @scope('cell_item', $log)
                    {{-- search in item for finding corrent one --}}
                    @if (!is_null($this->show_log_item($log->item)))
                        {{ $this->show_log_item($log->item) }}
                    @else
                        {{ $log->item }}
                    @endif
                    @php
                        $itemType = explode(':', $log->item)[0];
                    @endphp
                    <div class="italic text-sm inline-block text-blue-200 bg-blue-500/30 rounded-md mx-2 px-2">
                        {{ $itemType }}
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>
    <p class="mt-2 ml-2 italic font-semibold text-sky-500">Maximální doba uložených záznamů jsou 2 měsíce</p>

    <x-modal wire:model="detailModal" class="modal-bottom sm:modal-middle fixed">
        <div class="my-4 overflow-y-auto h-96">
            <div>
                <pre>
                    <code>
                        {{ json_encode($selectedLogDetail, JSON_PRETTY_PRINT) }}
                    </code>
            </pre>
            </div>

        </div>
        <div class="flex justify-between">
            <div>
            </div>
            <div>
                <x-button label="Zavřít"
                    class="bg-sky-800 hover:bg-sky-700 border-none text-white font-semibold w-full sm:w-28"
                    wire:click='closeModal' />
            </div>
        </div>
    </x-modal>

</div>
