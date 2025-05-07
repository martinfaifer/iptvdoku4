<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 md:col-span-3 ">
                <x-button
                    class="btn btn-sm btn-doku-primary mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový štítek
                </x-button>
            </div>
        </div>

        <div>
            <x-table class="" :headers="$headers" :rows="$tags" with-pagination>
                @scope('cell_color', $tag)
                    <x-share.cards.color-card color="{{ $tag->color }}"></x-share.cards.color-card>
                @endscope
                @scope('cell_actions', $tag)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="destroy({{ $tag->id }})" wire:confirm="Opravdu odebrat štítek?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    {{-- create modal --}}
    <x-modal wire:model="createModal" persistent class="modal-bottom sm:modal-middle fixed"  box-class="overflow-visible">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Název" wire:model="name" />
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
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
