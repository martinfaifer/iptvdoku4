@php
    $config = [
        'toolbar' =>
            'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent|link image | media | fullscreen | preview',
        'quickbars_selection_toolbar' => 'bold italic link',
        'plugins' => 'media, preview, fullscreen',
    ];
@endphp
<div>
    <button class='btn bg-[#082f49] btn-sm border-none' wire:click="openModal()" wire:keydown.ctrl.a="openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat článek
    </button>

    <x-modal wire:model="storeModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Nadpis" wire:model="form.title" />
                    <div>
                        @error('title')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-editor wire:model="form.text" label="Obsah" :config="$config" />

                    {{-- <x-markdown wire:model="form.text" label="Obsah" /> --}}
                    <div>
                        @error('text')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Vyberte kategorii" wire:model="form.wiki_category_id" :options="$categories"
                        searchable single>
                    </x-choices-offline>
                    <div>
                        @error('wiki_category_id')
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
