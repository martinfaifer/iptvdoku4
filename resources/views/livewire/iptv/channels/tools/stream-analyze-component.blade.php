<div class="mt-16">
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 xl:col-span-5 mb-4">
            <x-share.cards.base-card title="Dostupné streamy k analýze">
                <div class="h-52">
                    <div class="grid grid-cols-12 gap-4">
                        <div class=" fixed h-48 w-full overflow-y-auto">
                            @foreach ($streams as $stream)
                                <div wire:key='{{ $stream }}' class="col-span-12">
                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-8 m-4">
                                            {{ $stream }}
                                        </div>
                                        <div class="col-span-4">
                                            <button class="btn bg-[#082f49] btn-sm border-none mt-2"
                                                @click='$wire.analyze("{{ $stream }}")'>
                                                <div wire:loading wire:target="analyze('{{ $stream }}')">
                                                    <span class="loading loading-spinner loading-md"></span>
                                                </div>
                                                Analyzovat
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-share.cards.base-card>
        </div>
        <div class="col-span-12 xl:col-span-7 mb-4">
            <x-share.cards.base-card title="Uložené analýzy">
                <div class="h-52">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 fixed h-48 w-[95%] overflow-y-auto">
                            <x-table :headers="$headers" :rows="$analyzedStreams">
                                @scope('cell_actions', $analyzedStream)
                                    <button @click="$wire.openAnalyzeModal('{{ json_encode($analyzedStream['analyze']) }}')"
                                        class="btn btn-xs bg-transparent border-none">
                                        <x-heroicon-o-magnifying-glass class="size-4 text-blue-500" />
                                    </button>
                                @endscope
                            </x-table>
                        </div>
                    </div>
                </div>
            </x-share.cards.base-card>

            <x-modal wire:model.live="analyzedModal" class="modal-bottom sm:modal-middle fixed" title="">
                <div class="my-4 overflow-y-auto h-96">
                    <div>
                        <pre>
                            <code>
                                {{ json_encode($analyzed, JSON_PRETTY_PRINT) }}
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
                            @click='$wire.closeModal' />
                    </div>
                </div>
            </x-modal>
        </div>
    </div>
</div>
