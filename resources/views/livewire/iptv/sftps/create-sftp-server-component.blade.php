<div>
    <button class='btn btn-doku-navigation btn-sm' @click="$wire.openModal()" wire:keydown.ctrl.a="openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat sftp server
    </button>

    <x-modal wire:model="storeModal" title="Nový sftp server" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-4 mb-4">
                    <x-input label="Popis serveru" wire:model="storeForm.name" />
                </div>
                <div class="col-span-12 md:col-span-4 mb-4">
                    <x-choices label="Typ připojení" :options="$connectionTypes" wire:model="storeForm.connection_type" single />
                </div>
                <div class="col-span-12 md:col-span-4 mb-4">
                    <x-input label="Url" wire:model="storeForm.url" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Uživatelské jméno pro připojení" wire:model="storeForm.username" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Heslo" wire:model="storeForm.password" />
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="Cesta k adreáři" wire:model="storeForm.path_to_folder" />
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
