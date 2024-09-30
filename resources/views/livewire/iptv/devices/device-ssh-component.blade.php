<div>
    @if (!is_null($deviceSsh))
        <x-share.cards.base-card title="SSH">
            <div class="h-32 text-[#A3ABB8]">
                <div>
                    <button
                        class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-8 text-sky-500"
                        wire:click='openUpdateModal()'>
                        <x-heroicon-s-pencil class="w-4 h-4" />
                    </button>

                    <button
                    class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-red-500"
                    wire:click='destroy()' wire:confirm='Opravdu chcete odebrat? Pokud existuje štítek s vazbou na ssh budete znovu vyzváni k založení'>
                    <x-heroicon-s-trash class="w-4 h-4" />
                </button>
                </div>

                <div class="grid grid-cols-12">
                    <div class="col-span-12 md:col-span-6">
                        <span>
                            Uživatelské jméno:
                        </span>
                        <span class="ml-4 font-semibold">
                            {{ $deviceSsh->username }}
                        </span>
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <span>
                            Heslo:
                        </span>
                        <span class="ml-4 font-semibold">
                            {{ $deviceSsh->password }}
                        </span>
                    </div>
                </div>
            </div>
        </x-share.cards.base-card>
    @endif
    <x-modal wire:model="storeModal" title="Přidání ssh přístupu" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6 mb-4">
                    <x-input label="Uživatelské jméno" wire:model="username" />
                    <div>
                        @error('form.username')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-6 mb-4">
                    <x-input label="Heslo" wire:model="password" />
                    <div>
                        @error('form.password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
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

    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6 mb-4">
                    <x-input label="Uživatelské jméno" wire:model="username" />
                    <div>
                        @error('form.username')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-6 mb-4">
                    <x-input label="Heslo" wire:model="password" />
                    <div>
                        @error('form.password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
