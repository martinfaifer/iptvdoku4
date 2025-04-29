<div>
    <button class='btn btn-doku-navigation btn-sm' @click="$wire.openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat zařízení
    </button>

    <x-modal wire:model="storeModal" title="Nové zařízení" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Název" wire:model="form.name" />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 xl:col-span-6 mb-4">
                    <x-choices label="Typ" wire:model="form.device_category_id" :options="$deviceCategories" single />
                    <div>
                        @error('device_category_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 xl:col-span-6 mb-4">
                    <x-choices label="Výrobce" wire:model="form.device_vendor_id" :options="$devicesVendors" single />
                    <div>
                        @error('device_vendor_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 xl:col-span-4 mb-4">
                    <x-input label="IP" wire:model="form.ip" />
                    <div>
                        @error('ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 mb-4">
                    <x-input label="IPMI" wire:model="form.ipmi_ip" />
                    <div>
                        @error('ipmi_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 mb-4">
                    <x-input label="Url kontroleru" wire:model="form.controller_ip" />
                    <div>
                        @error('controller_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6 mb-4">
                    <x-input label="Uživatelské jméno" wire:model="form.username" />
                    <div>
                        @error('username')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6 mb-4">
                    <x-input label="Heslo" wire:model="form.password" />
                    <div>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 mb-4">
                    <x-checkbox label="SNMP?" wire:model="form.is_snmp" />
                    <div>
                        @error('is_snmp')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-8 mb-4">
                    <x-choices label="SNMP verze" wire:model="form.snmp_version" :options="$deviceSnmps" single />
                    <div>
                        @error('snmp_version')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6 mb-4">
                    <x-input label="SNMP public komunita" wire:model="form.snmp_public_comunity" />
                    <div>
                        @error('snmp_public_comunity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6 mb-4">
                    <x-input label="SNMP private komunita" wire:model="form.snmp_private_comunity" />
                    <div>
                        @error('snmp_private_comunity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
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
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
