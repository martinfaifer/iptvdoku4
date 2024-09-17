<div>
    <button class='btn bg-[#082f49] btn-xs md:btn-sm border-none' @click="$wire.openModal()">
        <x-heroicon-o-plus-circle class="hidden md:block size-5" />
        Přidat vazbu na zařízení
    </button>

    <x-modal wire:model.live="storeModal" title="Nová vazba na zařízení" persistent
        class="modal-bottom sm:modal-middle fixed" box-class="overflow-visible">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Zařízení" wire:model.live="form.deviceId" :options="$devices" single searchable />
                </div>
                <div class="col-span-12 mb-4">
                    <x-toggle label="Záloha" wire:model.live="form.is_backup" />
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
                        type="submit" spinner="create" />
                </div>
            </div>
        </x-form>

    </x-modal>

</div>
