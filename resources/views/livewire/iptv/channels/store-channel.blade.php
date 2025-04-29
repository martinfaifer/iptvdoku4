<div>
    <button class="btn btn-doku-navigation btn-xs md:btn-sm" wire:click="$toggle('storeModal')">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat kanál
    </button>

    <x-modal wire:model="storeModal" title="Nový kanál" persistent class="modal-bottom sm:modal-middle backdrop-blur-sm">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                {{-- name --}}
                <div class="col-span-12 mb-4">
                    <x-input label="Název" wire:model="name" />
                    <div>
                        @error('form.name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- logo --}}
                <div class="col-span-12 mb-4">
                    <input type="file" wire:model="logo">
                    <div>
                        @error('form.logo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- qualities --}}
                <div class="col-span-4 mb-4">
                    <x-choices label="Kvalita" wire:model="quality" :options="$qualities" single />
                    <div>
                        @error('form.quality')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- channel category --}}
                <div class="col-span-4 mb-4">
                    <x-choices label="Žánr" wire:model="category" :options="$channelCategories" single />
                    <div>
                        @error('form.category')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- channel programers --}}
                <div class="col-span-4 mb-4">
                    <x-choices label="Programer" wire:model="programer" :options="$channelProgramers" single />
                    <div>
                        @error('form.programer')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- geniustv packages --}}
                <div class="col-span-6 mb-4">
                    <x-choices label="GeniusTV balíčky" wire:model="geniustvChannelPackage" :options="$geniusTVChannelPackages"
                        multiple />
                    <div>
                        @error('form.geniustvChannelPackage')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- epgs --}}
                <div class="col-span-6 mb-4">
                    <x-choices-offline label="EPG" wire:model="epgId" :options="$channelsEpgs" searchable single />
                    <div>
                        @error('form.epgId')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- NANGU section --}}
                <div class="col-span-6 mb-4">
                    <x-input label="Nangu chunk store ID" wire:model="nangu_chunk_store_id" />
                    <div>
                        @error('form.nangu_chunk_store_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-input label="Nangu channel code" wire:model="nangu_channel_code" />
                    <div>
                        @error('form.nangu_channel_code')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- is_radio --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Rádio ?" wire:model="is_radio" />
                    <div>
                        @error('form.is_radio')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- is_multiscreen --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Multiscreen ?" wire:model="is_multiscreen" />
                    <div>
                        @error('form.is_multiscreen')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- channel region --}}
                <div class="col-span-12 mb-4">
                    <div class="grid grid-cols-12 gap-4">
                        @foreach ($regions as $region)
                            <div class="col-span-12">
                                <div class="form-control">
                                    <label class="label cursor-pointer">
                                        <span class="label-text font-semibold">Vysílání na území
                                            {{ $region->name }}</span>
                                        <input type="radio" name="region" class="radio checked:bg-indigo-500"
                                            value="{{ $region->id }}" wire:model='selectedRegion' />
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        <div>
                            @error('form.selectedRegion')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-span-12 mb-4">
                    <x-textarea placeholder="Popis kanálu" wire:model="description" hint="Max 1000 znaků" rows="5"
                        inline />
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="bg-sky-800 hover:bg-sky-700  hover:shadow-sky-700/50 border-none text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="store">
                    </x-button>
                </div>
            </div>
        </x-form>

    </x-modal>
</div>
