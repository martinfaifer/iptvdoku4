<div>
    <x-share.cards.base-card title="">
        <div class="flex justify-between">
            <div class="w-96">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query" class="!bg-[#0F151F] input-md placeholder:text-gray-600"
                    icon="o-magnifying-glass" autofocus />
            </div>
            <div class="w-64">
                <x-button class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm" wire:click="openCreateModal">
                    + Nový štítek
                </x-button>
            </div>
        </div>
        <div>
            <x-table :headers="$headers" :rows="$tags" with-pagination>
                @scope('cell_color', $tag)
                    <x-share.cards.color-card color="{{ $tag->color }}"></x-share.cards.color-card>
                @endscope
                @scope('cell_actions', $tag)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $tag->id }})" wire:confirm="Opravdu odebrat štítek?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    {{-- create modal --}}
    <x-modal wire:model="createModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Název" wire:model="name" />
                    <div>
                        @error('form.name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Barva" wire:model="color" :options="$cssColors" option-label="color" single
                        searchable>
                        @scope('item', $cssColor)
                            <x-list-item :item="$cssColor" sub-value="color">
                                <x-slot:avatar>
                                    <x-share.cards.color-card color="{{ $cssColor->color }}"></x-share.cards.color-card>
                                </x-slot:avatar>
                            </x-list-item>
                        @endscope

                        @scope('selection', $cssColor)
                            <x-share.cards.color-card color="{{ $cssColor->color }}"></x-share.cards.color-card>
                        @endscope
                    </x-choices-offline>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
