<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-button
                    class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový poplatek za offer
                </x-button>
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$offerTaxes" with-pagination>
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
                @scope('cell_actions', $offerTax)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="edit({{ $offerTax->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $offerTax->id }})" wire:confirm="Opravdu odebrat poplatek?">
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
                    <x-input label="Offer" wire:model="form.offer" />
                    <div>
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
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
                    <x-input disabled readonly label="Offer" wire:model="updateForm.offer" />
                    <div>
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Kanály" wire:model="updateForm.channels_id" :options="$channels" searchable />
                    <div>
                        @error('name')
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
                    <x-choices-offline label="Měna" wire:model="updateForm.currency" :options="$currencies" searchable single />
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
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
