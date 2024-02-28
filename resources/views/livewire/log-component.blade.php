<div>
    <x-share.cards.base-card title="Historie">
        <div class="h-44">
            <div class="overflow-x-auto">
                <table class="table table-sm w-full">
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

    <x-modal wire:model="detailModal" title="Provedené změny">
        <div class="my-4">
            <div class="grig grid-cols-12 gap-4">
                @foreach ($selectedLogDetail as $logKey => $logValue)
                    <div class="col-span-12">
                        <p class="font-semibold">
                            <span class="font-normal">
                                {{ $logKey }}:
                            </span>
                            <span class="ml-3">
                                {{ $logValue }}
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-between">
            <div>
            </div>
            <div>
                <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                    wire:click='closeModal' />
            </div>
        </div>
    </x-modal>
</div>
