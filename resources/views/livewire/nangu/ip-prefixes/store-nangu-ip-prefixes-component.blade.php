<div>
    <button class='btn btn-sm btn-doku-navigation' wire:click="openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat prefix
    </button>

    <x-modal wire:model="storeModal" title="Nový prefix" persistent class="modal-bottom sm:modal-middle fixed"
        box-class="overflow-visible">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="IPv4" wire:model="form.ip_address" />
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Prefix" wire:model='form.cidr' :options="$cidr" searchable single />
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="ISP" wire:model="form.nangu_isp_id" :options="$nanguIsps" searchable single />
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="store" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
