<div>
    <button class='btn bg-[#082f49] btn-sm border-none' @click="$wire.openModal()" >
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat satelitní kartu
    </button>

    <x-modal wire:model="storeModal" title="Nová satelitní karta" persistent class="modal-bottom sm:modal-middle fixed"  box-class="overflow-visible">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Číslo karty" wire:model="storeForm.name" />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-choices-offline label="Distributor" wire:model="storeForm.satelit_card_vendor_id" :options="$satelitCardsVendors" single searchable />
                    <div>
                        @error('satelit_card_vendor_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
