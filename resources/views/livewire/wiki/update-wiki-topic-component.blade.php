@php
    $config = [
        'toolbar' =>
            'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent|link image | media | fullscreen | preview',
        'quickbars_selection_toolbar' => 'bold italic link',
        'plugins' => 'media, preview, fullscreen',
    ];
@endphp
<div>
    <button class="btn btn-sm btn-doku-icon mt-7 ml-3" wire:click="edit">
        <x-icon name="s-pencil" class="w-4 h-4 text-green-500" />
    </button>

    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Nadpis" wire:model="form.title" />
                </div>
                <div class="col-span-12 mb-4">
                    <x-textarea wire:model="form.text" label="Obsah" rows="20"/>
                    {{-- <template x-if="$wire.updateModal">
                        <x-editor wire:model="form.text" label="Obsah" :config="$config" />
                    </template> --}}
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
                    <x-button label="Zavřít" class="btn btn-doku-close mb-4 w-full sm:w-28"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
