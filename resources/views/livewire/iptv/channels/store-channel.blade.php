<div>
    <button class="btn btn-doku-navigation btn-xs md:btn-sm" wire:click="$toggle('storeModal')">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat kanál
    </button>

    <x-modal wire:model="storeModal" title="Nový kanál" persistent class="modal-bottom sm:modal-middle backdrop-blur-sm"
        box-class="!max-w-6xl">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                {{-- name --}}
                <div class="col-span-12 mb-4">
                    <x-input label="Název" wire:model="form.name" />
                </div>
                {{-- logo --}}
                <div class="col-span-12 mb-4">
                    <input type="file" wire:model="form.logo">
                </div>
                {{-- qualities --}}
                <div class="col-span-4 mb-4">
                    <x-choices label="Kvalita" wire:model="form.quality" :options="$qualities" single />
                </div>
                {{-- channel category --}}
                <div class="col-span-4 mb-4">
                    <x-choices label="Žánr" wire:model="form.category" :options="$channelCategories" single />
                </div>
                {{-- channel programers --}}
                <div class="col-span-4 mb-4">
                    <x-choices label="Programer" wire:model="form.programer" :options="$channelProgramers" single />
                </div>
                {{-- geniustv packages --}}
                <div class="col-span-6 mb-4">
                    <x-choices label="GeniusTV balíčky" wire:model="form.geniustvChannelPackage" :options="$geniusTVChannelPackages"
                        multiple />
                </div>
                {{-- epgs --}}
                <div class="col-span-6 mb-4">
                    <x-choices-offline label="EPG" wire:model="form.epgId" :options="$channelsEpgs" searchable single />
                </div>
                {{-- NANGU section --}}
                <div class="col-span-6 mb-4">
                    <x-input label="Nangu chunk store ID" wire:model="form.nangu_chunk_store_id" />
                </div>
                <div class="col-span-6 mb-4">
                    <x-input label="Nangu channel code" wire:model="form.nangu_channel_code" />
                </div>
                {{-- is_radio --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Rádio ?" wire:model="form.is_radio" />
                </div>
                {{-- is_multiscreen --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Multiscreen ?" wire:model="form.is_multiscreen" />
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
                                            value="{{ $region->id }}" wire:model='form.selectedRegion' />
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
                    <x-textarea placeholder="Popis kanálu" wire:model="form.description" hint="Max 1000 znaků"
                        rows="5" inline />
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28" type="submit" spinner="store">
                    </x-button>
                </div>
            </div>
        </x-form>

    </x-modal>
</div>
