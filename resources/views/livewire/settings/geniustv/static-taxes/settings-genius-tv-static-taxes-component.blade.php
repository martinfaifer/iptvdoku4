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
                    + Nový poplatek
                </x-button>
            </div>
        </div>
        <div>
            <x-table :headers="$headers" :rows="$staticTaxes" with-pagination>
                @scope('cell_actions', $staticTax)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="edit({{ $staticTax->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $staticTax->id }})" wire:confirm="Opravdu odebrat poplatek?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model.live="createModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Poplatek" wire:model.live="form.name" />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="cena" wire:model.live="form.price" />
                    <div>
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Měna" wire:model.live="form.currency" :options="$currencies" searchable single />
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

    {{-- edit --}}
    <x-modal wire:model.live="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input readonly disabled label="Poplatek" wire:model.live="updateForm.name" />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="cena" wire:model.live="updateForm.price" />
                    <div>
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Měna" wire:model.live="updateForm.currency" :options="$currencies" searchable
                        single />
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
