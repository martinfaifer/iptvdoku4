<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-7 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-5 sm:col-span-3">
                <x-button
                    class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm mt-2 absolute right-10"
                    wire:click="openCreateModal">
                    + Nový ISP
                </x-button>
            </div>
        </div>
        <div>
            <x-table :headers="$headers" :rows="$nanguIsps" with-pagination>
                @scope('cell_actions', $nanguIsp)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="edit({{ $nanguIsp->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
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
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Nangu isp id" wire:model="createForm.nangu_isp_id" />
                    <div>
                        @error('nangu_isp_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="IČ" wire:model="createForm.ic" />
                    <div>
                        @error('ic')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="DIČ" wire:model="createForm.dic" />
                    <div>
                        @error('dic')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="HBO klíč" wire:model="createForm.hbo_key" />
                    <div>
                        @error('hbo_key')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="CRM contract id" wire:model="createForm.crm_contract_id" />
                    <div>
                        @error('crm_contract_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-checkbox class="border-[#085885] active:bg-[#085885]" label="Akcionář ISP alliance" wire:model="createForm.is_akcionar" hint="Bude uplatněna sleva" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
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
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Nangu isp id" wire:model="updateForm.nangu_isp_id"  disabled readonly/>
                    <div>
                        @error('nangu_isp_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="IČ" wire:model="updateForm.ic" />
                    <div>
                        @error('ic')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="DIČ" wire:model="updateForm.dic" />
                    <div>
                        @error('dic')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="HBO klíč" wire:model="updateForm.hbo_key" />
                    <div>
                        @error('hbo_key')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="CRM contract id" wire:model="updateForm.crm_contract_id" />
                    <div>
                        @error('crm_contract_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-checkbox class="border-[#085885] active:bg-[#085885]" label="Akcionář ISP alliance" wire:model="createForm.is_akcionar" hint="Bude uplatněna sleva" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
