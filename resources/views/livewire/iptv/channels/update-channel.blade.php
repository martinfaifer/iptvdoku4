<div>
    <button class="btn btn-circle btn-sm mt-7 ml-3 bg-transparent border-none" @click="$wire.edit">
        <x-icon name="s-pencil" class="w-4 h-4 text-green-500" />
    </button>

    <x-modal wire:model="updateModal" title="Úprava kanálu" persistent class="modal-bottom sm:modal-middle">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                {{-- name --}}
                <div class="col-span-12 mb-4">
                    <x-input label="Název" wire:model="form.name" />
                    <div>
                        @error('name')
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
                <div class="col-span-6 mb-4">
                    <x-choices-offline label="Kvalita" wire:model="form.quality" :options="$qualities" single
                        searchable />
                    <div>
                        @error('quality')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- channel category --}}
                <div class="col-span-6 mb-4">
                    <x-choices-offline label="Žánr" wire:model="form.category" :options="$channelCategories" single
                        searchable />
                    <div>
                        @error('category')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-choices-offline label="GeniusTV balíčky" wire:model="form.geniustvChannelPackage"
                        :options="$geniusTVChannelPackages" multiple searchable />
                    <div>
                        @error('geniustvChannelPackage')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- epgs --}}
                <div class="col-span-6 mb-4">
                    <x-choices-offline label="EPG" wire:model="form.epgId" :options="$channelsEpgs" searchable
                        single />
                    <div>
                        @error('epgId')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- NANGU section --}}
                <div class="col-span-6 mb-4">
                    <x-input label="Nangu chunk store ID" wire:model="form.nangu_chunk_store_id" />
                    <div>
                        @error('nangu_chunk_store_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-input label="Nangu channel code" wire:model="form.nangu_channel_code" />
                    <div>
                        @error('nangu_channel_code')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- is_radio --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Rádio ?" wire:model="form.is_radio" />
                    <div>
                        @error('is_radio')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- is_multiscreen --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Multiscreen ?" wire:model="form.is_multiscreen" />
                    <div>
                        @error('is_multiscreen')
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
                                            value="{{ $region->id }}"
                                            @checked($region->id == $form->selectedRegion)
                                            wire:model='form.selectedRegion' />
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-12 mb-4">
                    <x-textarea placeholder="Popis kanálu" wire:model="form.description" hint="Max 1000 znaků"
                        rows="5" inline />
                </div>
                <div>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-sky-700/50 border-none text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
