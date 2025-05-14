<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="dark:!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-button class="btn btn-sm btn-doku-primary mt-2 absolute right-5 md:right-10" wire:click="store">
                    + Nový balíček
                </x-button>
            </div>
        </div>
        <div>
            <x-table :headers="$headers" :rows="$tvPackages" with-pagination>
                @scope('cell_is_optional', $tvPackage)
                    @if ($tvPackage->is_optional == true)
                        <x-icon name="o-check" class="text-green-500 w-4 h-4" />
                    @else
                        <x-icon name="o-x-mark" class="text-red-500 w-4 h-4" />
                    @endif
                @endscope
                @scope('cell_actions', $tvPackage)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="edit({{ $tvPackage->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="destroy({{ $tvPackage->id }})" wire:confirm="Opravdu odebrat baliček?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model="createModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeModal'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="Balíček" wire:model="createForm.name" />
                </div>
                <div class="col-span-12">
                    <x-checkbox label="Příplatkový balíček" wire:model="createForm.is_optional" />
                </div>

            </div>
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" wire:click='closeModal' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeModal'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="Balíček" wire:model="updateForm.name" />
                </div>
                <div class="col-span-12">
                    <x-checkbox label="Příplatkový balíček" wire:model="updateForm.is_optional" />
                </div>
            </div>
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" wire:click='closeModal' />
                </div>
                <div>
                    <x-button label="Upravit" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
