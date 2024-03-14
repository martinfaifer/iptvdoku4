<div>
    <x-button label="Přidat událost" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full" type="submit"
        spinner="save2" wire:click='openModal()' />

    {{-- create modal --}}
    <x-modal wire:model="storeModal" title="Nová událost" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeModal'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Název události" wire:model="form.label" />
                    <div>
                        @error('label')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-input type="date" label="Den začátku události" wire:model="form.start_date" />
                    <div>
                        @error('start_date')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-input type="time" label="Čas začátku události" wire:model="form.start_time" />
                    <div>
                        @error('start_time')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-input type="date" label="Den konce události" wire:model="form.end_date" />
                    <div>
                        @error('end_date')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-input type="time" label="Čas konce události" wire:model="form.end_time" />
                    <div>
                        @error('end_time')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-choices-offline label="Vyberte uživatele pro upozornění" wire:model="form.users"
                        :options="$users" option-label="email" searchable>
                    </x-choices-offline>
                    <div>
                        @error('users')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-markdown wire:model="form.description" label="Popis události" />

                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeModal' />
                </div>
                <div>
                    <x-button label="Přidat" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
