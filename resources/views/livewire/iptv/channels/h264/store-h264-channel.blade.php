<div>
    <button class='btn btn-doku-navigation btn-xs md:btn-sm' @click="$wire.openModal()">
        <x-heroicon-o-plus-circle class="hidden md:block size-5" />
        Přidat unicast
    </button>

    <x-modal wire:model="storeModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                {{-- outputs --}}
                @foreach ($availableFormats as $availableFormat)
                    <div class="col-span-12 mb-4">
                        <x-input label="{{ $availableFormat->name }}"
                            wire:model="form.ips.{{ $availableFormat->id }}" />
                        <div>
                            @error('ips')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="store" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
