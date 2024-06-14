<div>
    <button class="btn btn-circle btn-sm mt-7 ml-3 bg-transparent border-none" @click="$wire.edit">
        <x-icon name="s-pencil" class="w-4 h-4 text-green-500" />
    </button>

    <x-modal wire:model="updateModal" title="Úprava satelitní karty" persistent class="modal-bottom sm:modal-middle"  box-class="overflow-visible">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Číslo karty" wire:model="updateForm.name" disabled readonly/>
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-choices-offline label="Distributor" wire:model="updateForm.satelit_card_vendor_id"
                        :options="$satelitCardsVendors" single searchable />
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
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28" type="submit"
                        spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
