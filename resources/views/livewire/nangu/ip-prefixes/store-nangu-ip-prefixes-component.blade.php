<div>
    <button class='btn bg-[#082f49] btn-sm border-none' wire:click="openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat prefix
    </button>

    <x-modal wire:model.live="storeModal" title="Nový prefix" persistent class="modal-bottom sm:modal-middle fixed"
        box-class="overflow-visible">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 xl:col-span-8 mb-4">
                    <x-input label="IPv4" wire:model.live="form.ip_address" />
                </div>
                <div class="col-span-12 xl:col-span-4 mb-4">
                    <x-choices-offline label="Prefix" wire:model.live='form.cidr' :options="$cidr" searchable single />
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="ISP" wire:model.live="form.nangu_isp_id" :options="$nanguIsps" searchable single />
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
