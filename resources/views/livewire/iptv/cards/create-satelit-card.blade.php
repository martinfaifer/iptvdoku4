<div>
    <button class='btn btn-doku-navigation btn-sm ' @click="$wire.openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat satelitní kartu
    </button>

    <x-modal wire:model="storeModal" persistent class="modal-bottom sm:modal-middle fixed"
        box-class="overflow-visible">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Číslo karty" wire:model="storeForm.name" />
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Distributor" wire:model="storeForm.satelit_card_vendor_id"
                        :options="$satelitCardsVendors" single searchable />
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn-doku-close w-full sm:w-28"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
