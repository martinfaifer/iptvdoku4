<div>
    <x-share.cards.base-card title="Expirace">
        <div>
            <button
                class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-green-500"
                @click='$wire.openStoreModal()'>
                <x-heroicon-o-plus-circle class="w-4 h-4" />
            </button>
        </div>
        <div class="grid grid-cols-12 gap-4 font-semibold text-[#A3ABB8]">
            <div class="col-span-12">
                {{-- show expiration if is not null --}}
                @if (!is_null($satelitCard->expiration))
                    <p>
                        <span class="font-normal">
                            Expirace nastane:
                        </span>
                        <span class="ml-3">
                            {{ $satelitCard->expiration }}
                            <button @click='$wire.openEditModal()' class="ml-1 inline btn-sm bg-transparent border-none">
                                <x-heroicon-o-pencil class="size-4 text-green-500" />
                            </button>
                            <button wire:click='destroy()' class="inline btn-sm bg-transparent border-none" wire:submit='Opravdu odebrat expiraci?'>
                                <x-heroicon-o-trash class="size-4 text-red-500" />
                            </button>
                        </span>
                    </p>
                @else
                    {{-- show alert if is null --}}
                    <x-share.alerts.info title="Není nastavena expirace"></x-share.alerts.info>
                @endif
            </div>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model="storeModal" title="Nová expirace karty" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input type="date" label="Expirace" wire:model="createForm.expiration" />
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
                        type="submit" spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="editModal" title="Změna expirace karty" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input type="date" label="Expirace" wire:model="updateForm.expiration" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
