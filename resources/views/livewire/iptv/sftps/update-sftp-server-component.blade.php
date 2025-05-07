<div>
    <button class="btn btn-circle btn-sm mt-7 ml-3 bg-transparent border-none shadow-none" @click="$wire.edit">
        <x-icon name="s-pencil" class="w-4 h-4 text-green-500" />
    </button>

    <x-modal wire:model="updateModal" title="Úprava sftp serveru" persistent class="modal-bottom sm:modal-middle">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="Uživatelské jméno pro připojení" wire:model="updateForm.username" />
                </div>
                <div class="col-span-12">
                    <x-input label="Heslo" wire:model="updateForm.password" />
                </div>
                <div class="col-span-12">
                    <x-input label="Cesta k adreáři" wire:model="updateForm.path_to_folder" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
