<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query" class="input-md placeholder:text-gray-600"
                    icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 md:col-span-3">
                <x-button class="btn btn-sm btn-doku-primary mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový programer
                </x-button>
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$programers" with-pagination>
                @scope('cell_actions', $programmer)
                    <div class="flex mx-auto gap-4">
                        {{-- <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="edit({{ $programmer->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button> --}}
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $programmer->id }})" wire:confirm="Opravdu odebrat programera?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
                @scope('cell_contacts.name', $programmer)
                    @foreach ($programmer->contacts as $contact)
                        <p>
                            {{ $contact->name }}
                        </p>
                    @endforeach
                @endscope
                @scope('cell_contacts.email', $programmer)
                    @foreach ($programmer->contacts as $contact)
                        <p>
                            {{ $contact->email }}
                        </p>
                    @endforeach
                @endscope
                @scope('cell_contacts.phone', $programmer)
                    @foreach ($programmer->contacts as $contact)
                        <p>
                            {{ $contact->phone }}
                        </p>
                    @endforeach
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model="createModal" persistent class="modal-bottom xl:modal-middle fixed"
        box-class="overflow-visible">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="Programer" wire:model="createForm.name" />
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4" wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
