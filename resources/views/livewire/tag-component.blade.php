<div>
    {{-- {{ $tags }} --}}
    <div class="navbar bg-transparent min-h-8">
        <div class="flex-1">
            {{--  --}}
        </div>
        <div class="flex flex-none gap-2">
            @foreach ($tagsOnItem as $tag)
                <div
                    class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 {{ $tag->tag->color }} text-neutral-200 rounded-md w-18 h-6">
                    <div class="inline-flex">
                        <div>
                            {{ $tag->tag->name }}
                        </div>
                        <div>
                            <x-heroicon-s-trash wire:click='destroy({{ $tag->id }})'
                                wire:confirm='Opravdu odebrat štítek?' class="cursor-pointer w-4 h-4 ml-3" />
                        </div>
                    </div>
                </div>
            @endforeach

            <div>
                <button wire:click='openModal()' class="btn btn-sm btn-circle bg-transparent border-none">+</button>
            </div>
        </div>
    </div>

    <x-modal wire:model="storeModal" title="Přídat štítek" persistent
        class="modal-bottom sm:modal-middle backdrop-blur-sm">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Štítky" wire:model="selectedTags" :options="$tags" searchable autofocus/>
                    <div>
                        @error('form.selectedTags')
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