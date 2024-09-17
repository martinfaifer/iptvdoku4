<div>
    <x-share.cards.base-card title="Historie">
        <div class="h-44">
            <div class="overflow-x-auto">
                <table class="table table-xs md:table-sm w-full text-[#A3ABB8]">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class=""></th>
                            <th class=""></th>
                        </tr>
                    </thead>
                    <tbody class="fixed h-32 overflow-y-auto">
                        @foreach ($logs as $log)
                            <tr>
                                <td class="text-xs xl:text-sm">{{ $log->user }}</td>
                                @if ($log->type == 'created')
                                    <td class="text-green-500 font-semibold text-xs xl:text-sm">Vytvořil</td>
                                @endif
                                @if ($log->type == 'updated')
                                    <td class="text-sky-500 font-semibold text-xs xl:text-sm">Upravil</td>
                                @endif
                                @if ($log->type == 'deleted')
                                    <td class="text-red-500 font-semibold text-xs xl:text-sm">Odebral</td>
                                @endif
                                <td class="text-xs xl:text-sm">{{ $log->created_at->format('d.m. Y') }}</td>
                                <td>
                                    <button class="btn btn-circle btn-sm bg-transparent border-none"
                                        wire:click='openModal({{ $log->payload }})'>
                                        <x-heroicon-o-magnifying-glass class="text-blue-500 h-3 w-3" />
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model.live="detailModal" class="modal-bottom sm:modal-middle fixed" title="Provedené změny">
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
                <x-button label="Zavřít" class="bg-sky-800 hover:bg-sky-700 border-none text-white font-semibold w-full sm:w-28"
                    wire:click='closeModal' />
            </div>
        </div>
    </x-modal>
</div>
