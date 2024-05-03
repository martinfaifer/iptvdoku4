<div>
    <button class="btn btn-circle btn-sm mt-7 ml-3 bg-transparent border-none" wire:click="edit">
        <x-icon name="s-pencil" class="w-4 h-4 text-green-500" />
    </button>

    <x-modal wire:model="updateModal" title="Úprava zařízení" persistent class="modal-bottom sm:modal-middle">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Název" wire:model="form.name" autofocus />
                    <div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-choices label="Typ" wire:model="form.device_category_id" :options="$deviceCategories" single />
                    <div>
                        @error('device_category_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 mb-4">
                    <x-choices label="Výrobce" wire:model="form.device_vendor_id" :options="$devicesVendors" single />
                    <div>
                        @error('device_vendor_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-4 mb-4">
                    <x-input label="IP" wire:model="form.ip" />
                    <div>
                        @error('ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-4 mb-4">
                    <x-input label="IPMI" wire:model="form.ipmi_ip" />
                    <div>
                        @error('ipmi_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-4 mb-4">
                    <x-input label="Url kontroleru" wire:model="form.controller_ip" />
                    <div>
                        @error('controller_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-6 mb-4">
                    <x-input label="Uživatelské jméno" wire:model="form.username" />
                    <div>
                        @error('username')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-6 mb-4">
                    <x-input label="Heslo" wire:model="form.password" />
                    <div>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-4 mb-0">
                    <x-checkbox label="SNMP?" wire:model="form.is_snmp" hint="Pouze pokud zařízení má podporu SNMP"/>
                    <div>
                        @error('is_snmp')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-8 mb-4">
                    <x-choices label="SNMP verze" wire:model="form.snmp_version" :options="$deviceSnmps" single />
                    <div>
                        @error('snmp_version')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-6 mb-4">
                    <x-input label="SNMP public komunita" wire:model="form.snmp_public_comunity" />
                    <div>
                        @error('snmp_public_comunity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-6 mb-4">
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
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28" type="submit"
                        spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
