<div>
    <button class='btn btn-doku-navigation btn-xs md:btn-sm' @click="$wire.openModal()">
        <x-heroicon-o-plus-circle class="hidden md:block size-5" />
        Přidat vazbu na zařízení
    </button>

    <x-modal wire:model="storeModal" persistent
        class="modal-bottom sm:modal-middle fixed" box-class="overflow-visible">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Zařízení" wire:model="form.deviceId" :options="$devices" single searchable />
                </div>
                <div class="col-span-12 mb-4">
                    <x-toggle label="Záloha" wire:model="form.is_backup" />
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close sm:w-28 mb-4"
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
