<div>
    <x-share.cards.base-card title="Nahrané soubory">
        <div>
            <button
                class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-green-500"
                @click='$wire.openStoreModal()'>
                <x-heroicon-o-plus-circle class="w-4 h-4" />
            </button>
        </div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                {{-- {{ json_encode($contents) }} --}}
                <x-table :headers="$headers" :rows="$contents" with-pagination>
                    @scope('cell_file_name', $content)
                        <a href="{{ config('app.url') . '/' . str_replace('public', 'storage', $content->path) }}"
                            target="_blank">{{ $content->file_name }}</a>
                    @endscope
                    @scope('cell_actions', $content)
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $content->id }})" wire:confirm="Opravdu odebrat soubor?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    @endscope
                </x-table>
            </div>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model.live="storeModal" title="Nový soubor" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-file wire:model.live="storeForm.file" label="Soubor" />
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
                        type="submit" spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
