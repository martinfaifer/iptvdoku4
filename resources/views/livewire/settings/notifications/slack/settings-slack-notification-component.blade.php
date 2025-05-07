<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query" class="input-md placeholder:text-gray-600"
                    icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-button class="btn btn-sm btn-doku-primary mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový kanál
                </x-button>
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$slackChannels" with-pagination>
                @scope('cell_action', $slackChannel)
                    @foreach ($this->slackActions as $translatedAction)
                        @if ($translatedAction['id'] == $slackChannel->action)
                            {{ $translatedAction['name'] }}
                        @endif
                    @endforeach
                @endscope
                @scope('cell_actions', $slackChannel)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="edit({{ $slackChannel->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="destroy({{ $slackChannel->id }})" wire:confirm="Opravdu odebrat?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    {{-- create modal --}}
    <x-modal wire:model="createModal" persistent class="modal-bottom sm:modal-middle" box-class="overflow-visible">
        <x-form wire:submit="create">

            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="Url" wire:model="createForm.url" />
                </div>
                <div class="col-span-12">
                    <x-input label="Popis" wire:model="createForm.description" />
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Akce" wire:model="createForm.action" :options="$slackActions" single
                        searchable />

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

    <x-modal wire:model="editModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <div class="my-4 overflow-y-auto h-96">
                <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                    wire:click='closeDialog'>✕</x-button>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <x-input label="Url" wire:model="updateForm.url" disabled />
                    </div>
                    <div class="col-span-12">
                        <x-input label="Popis" wire:model="updateForm.description" />
                    </div>
                    <div class="col-span-12">
                        <x-choices-offline label="Akce" wire:model="updateForm.action" :options="$slackActions" single
                            searchable />
                    </div>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
