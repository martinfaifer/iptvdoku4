<div>
    <x-button label="Přidat událost" class="btn btn-doku-primary w-full" type="submit" spinner="openModal"
        wire:click='openModal()' />

    {{-- create modal --}}
    <x-drawer wire:model="storeModal" right class="lg:w-2/3 dark:!bg-[#0E1E33]">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click='closeModal'>✕</x-button>
            <div class="overflow-y-auto">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 mb-4">
                        <x-input label="Název události" wire:model="form.label" />
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-input type="date" label="Den začátku události" wire:model="form.start_date" />
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-input type="time" label="Čas začátku události" wire:model="form.start_time" />
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-input type="date" label="Den konce události" wire:model="form.end_date" />
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-input type="time" label="Čas konce události" wire:model="form.end_time" />
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Vyberte kanál/y" wire:model="form.channels" :options="$channels"
                            searchable>
                        </x-choices-offline>
                        <div>
                            @error('users')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Štítek s akcí" wire:model="form.tag_id" :options="$tags" searchable
                            single>
                        </x-choices-offline>
                        <div>
                            @error('users')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- notifications  --}}
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Vyberte uživatele pro upozornění" wire:model="form.users"
                            :options="$users" option-label="email" searchable>
                        </x-choices-offline>
                        <div>
                            @error('users')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4 md:mt-10">
                        <x-checkbox label="Zobrazit upozornění v banneru?" wire:model="form.fe_notification" />
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Barva" wire:model="form.color" :options="$cssColors" option-label="color"
                            single searchable>
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
                    <div class="col-span-12"></div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Vyberte server pro nahrání banneru" wire:model="form.sftp_server_id"
                            :options="$sftpServers" single searchable>
                        </x-choices-offline>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-file label="Zde můžete nahrát banner" wire:model="form.banner" accept="image/png" />
                    </div>


                    <div class="col-span-12 mb-4">
                        <x-markdown wire:model="form.description" label="Popis události" />
                    </div>
                </div>
            </div>

            {{-- action section --}}
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
    </x-drawer>
</div>
