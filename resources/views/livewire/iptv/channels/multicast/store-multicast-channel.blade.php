<div>
    <button @class(['btn bg-[#082f49] btn-sm']) wire:click="openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat multicast
    </button>

    <x-modal wire:model="storeModal" title="Nový multicast" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeDialog'>✕</x-button>
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
                {{-- logo --}}
                <div class="col-span-12 mb-4">
                    <x-input label="Zdrojová IP" wire:model="form.source_ip" />
                    <div>
                        @error('source_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- qualities --}}
                <div class="col-span-12 mb-4">
                    <x-choices label="Zdroj" wire:model="form.channel_source_id" :options="$channelSources" single />
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
