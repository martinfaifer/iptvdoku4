<div>
    <button class="btn btn-circle btn-sm mt-7 ml-3 shadow-none bg-transparent border-none" @click="$wire.edit">
        <x-icon name="s-pencil" class="w-4 h-4 text-green-500" />
    </button>

    <x-modal wire:model="updateModal" title="Úprava satelitní karty" persistent class="modal-bottom sm:modal-middle"
        box-class="overflow-visible">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Číslo karty" wire:model="updateForm.name" disabled readonly />
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Distributor" wire:model="updateForm.satelit_card_vendor_id"
                        :options="$satelitCardsVendors" single searchable />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit" class="btn btn-doku-primary w-full sm:w-28" type="update"
                        spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
