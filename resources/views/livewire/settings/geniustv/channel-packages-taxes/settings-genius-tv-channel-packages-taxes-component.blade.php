<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live.debounce.500ms="query"
                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-button
                    class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový poplatek za balíček
                </x-button>
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$channelPackagesTaxes" with-pagination>
                @scope('cell_channels_id', $channelPackagesTax)
                    @foreach (json_decode($channelPackagesTax->channels_id) as $channel_id)
                        @php
                            $channel = null;

                            $channel = App\Models\Channel::find($channel_id);
                        @endphp
                        @if (!is_null($channel))
                            {{ $channel->name }} ,
                        @endif
                    @endforeach
                @endscope
                @scope('cell_exception', $channelPackagesTax)
                    @if ($channelPackagesTax->exception != '')
                        @foreach (json_decode($channelPackagesTax->exception) as $exception_id)
                            @php
                                $exception = null;
                                $exception = App\Models\Channel::find($exception_id);
                            @endphp
                            @if (!is_null($exception))
                                {{ $exception->name }} ,
                            @endif
                        @endforeach
                    @endif

                @endscope
                @scope('cell_must_contains_all', $channelPackagesTax)
                    @if ($channelPackagesTax->must_contains_all == true)
                        <x-heroicon-o-check class="text-green-500 size-4" />
                    @else
                        <x-heroicon-o-x-mark class="text-red-500 size-4" />
                    @endif
                @endscope
                @scope('cell_actions', $channelPackagesTax)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="edit({{ $channelPackagesTax->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $channelPackagesTax->id }})" wire:confirm="Opravdu odebrat poplatek?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model="createModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Kanály" wire:model="form.channels_id" :options="$channels" searchable />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input type="number" step="0.001" label="cena" wire:model="form.price" />
                    <div>
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Měna" wire:model="form.currency" :options="$currencies" searchable single />
                    <div>
                        @error('currency')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Kanály" wire:model="updateForm.channels_id" :options="$channels"
                        searchable />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Výjimky" wire:model="updateForm.exception" :options="$channels" searchable />
                    <div>
                        @error('exception')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input type="number" step="0.001" label="cena" wire:model="updateForm.price" />
                    <div>
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Měna" wire:model="updateForm.currency" :options="$currencies" searchable
                        single />
                    <div>
                        @error('currency')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-checkbox label="Musí obsahovat všechny kanály služba"
                        wire:model="updateForm.must_contains_all" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
