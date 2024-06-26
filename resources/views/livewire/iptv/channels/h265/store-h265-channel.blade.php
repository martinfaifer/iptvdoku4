<div>
    <button class='btn bg-[#082f49] btn-xs md:btn-sm border-none' @click="$wire.openModal()">
        <x-heroicon-o-plus-circle class="hidden md:block size-5" />
        Přidat unicast
    </button>

    <x-modal wire:model="storeModal" title="Nový výstup" persistent class="modal-bottom sm:modal-middle fixed">
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
