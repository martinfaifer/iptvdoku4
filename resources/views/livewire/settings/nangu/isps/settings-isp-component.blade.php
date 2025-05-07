<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="dark:!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-button class="btn btn-sm btn-doku-primary mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový ISP
                </x-button>
            </div>
        </div>
        <div>
            <x-table :headers="$headers" :rows="$nanguIsps" with-pagination>
                @scope('cell_is_akcionar', $nanguIsp)
                    @if ($nanguIsp->is_akcionar == true)
                        <x-heroicon-o-check class="size-4 text-green-500" />
                    @else
                        <x-heroicon-o-x-mark class="size-4 text-red-500" />
                    @endif
                @endscope
                @scope('cell_actions', $nanguIsp)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="edit({{ $nanguIsp->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="destroy({{ $nanguIsp->id }})" wire:confirm="Opravdu odebrat ISP?">
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
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Poskytovatel" wire:model="createForm.name" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Nangu isp id" wire:model="createForm.nangu_isp_id" />
                </div>

                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="IČ" wire:model="createForm.ic" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="DIČ" wire:model="createForm.dic" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="HBO klíč" wire:model="createForm.hbo_key" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="CRM contract id" wire:model="createForm.crm_contract_id" />
                </div>
                <div class="col-span-12 mb-4">
                    <x-checkbox class="border-[#085885] active:bg-[#085885]" label="Akcionář ISP alliance"
                        wire:model="createForm.is_akcionar" hint="Bude uplatněna sleva" />
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

    {{-- edit modal --}}
    <x-modal wire:model="editModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Poskytovatel" wire:model="updateForm.name" disabled readonly />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Nangu isp id" wire:model="updateForm.nangu_isp_id" disabled readonly />
                </div>

                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="IČ" wire:model="updateForm.ic" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="DIČ" wire:model="updateForm.dic" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="HBO klíč" wire:model="updateForm.hbo_key" />
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="CRM contract id" wire:model="updateForm.crm_contract_id" />
                </div>
                <div class="col-span-12 mb-4">
                    <x-checkbox class="border-[#085885] active:bg-[#085885]" label="Akcionář ISP alliance"
                        wire:model="updateForm.is_akcionar" hint="Bude uplatněna sleva" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4" wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
