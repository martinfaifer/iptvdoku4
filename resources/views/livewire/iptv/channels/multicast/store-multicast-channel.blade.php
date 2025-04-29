<div>
    <button class='btn btn-doku-navigation btn-xs md:btn-sm' @click="$wire.openModal()">
        <x-heroicon-o-plus-circle class="hidden md:block size-5" />
        Přidat multicast
    </button>

    <x-modal wire:model="storeModal" title="Nový multicast" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                {{-- name --}}
                <div class="col-span-12 mb-4">
                    <x-input label="IP k STB" wire:model="form.stb_ip" />
                    <div>
                        @error('stb_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="Zdrojová IP" wire:model="form.source_ip" />
                    <div>
                        @error('source_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline searchable label="Zdroj" wire:model="form.channel_source_id" :options="$channelSources" single />
                    <div>
                        @error('channel_source_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- is_backup --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Záloha" wire:model="form.is_backup" />
                    <div>
                        @error('is_backup')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- store to dohled --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Uložit do dohledu" wire:model="form.to_dohled" />
                    <div>
                        @error('to_dohled')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
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
                        type="submit" spinner="store" />
                </div>
            </div>
        </x-form>

    </x-modal>

</div>
