<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query" class="input-md placeholder:text-gray-600"
                    icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 md:col-span-3">
                <x-button
                    class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový uživatel
                </x-button>
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$users" with-pagination>
                @scope('cell_avatar', $user)
                    <div class="rounded-full size-8 bg-black flex items-center justify-center cursor-pointer">
                        @if (is_null($user->avatar_url))
                            <div class="font-semibold">
                                {{ $user->first_name[0] }}
                                {{ $user->last_name[0] }}
                            </div>
                        @else
                            <img class="object-contain rounded-full" src="{{ config('app.url') . '/' . $user->avatar_url }}"
                                alt="" />
                        @endif
                    </div>
                @endscope
                @scope('cell_actions', $user)
                    <div class="flex mx-auto gap-4">
                        @if (Auth::user()->id != $user->id)
                            <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                                wire:click="edit({{ $user->id }})">
                                <x-heroicon-o-pencil class="size-4 text-green-500" />
                            </button>
                            <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                                wire:click="resetPassword({{ $user->id }})"
                                wire:confirm="Opravdu poslat nové heslo uživately?">
                                <x-heroicon-o-lock-closed class="size-4 text-orange-500" />
                            </button>
                            <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                                wire:click="destroy({{ $user->id }})" wire:confirm="Opravdu odebrat uživatele?">
                                <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                            </button>
                        @endif
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    {{-- create modal --}}
    <x-modal wire:model="createModal" persistent class="modal-bottom xl:modal-middle fixed"
        box-class="overflow-visible">
        <x-form wire:submit="create">

            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Jméno" wire:model="form.first_name" />
                    <div>
                        @error('first_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Příjmení" wire:model="form.last_name" />
                    <div>
                        @error('last_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Email" wire:model="form.email" />
                    <div>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-choices-offline label="Uživatelská role" :options="$userRoles" wire:model="form.userRoleId" single
                        searchable />
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
    <x-modal wire:model="editModal" persistent class="modal-bottom xl:modal-middle fixed" box-class="overflow-visible">
        <x-form wire:submit="update">

            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Jméno" wire:model="editForm.first_name" />
                    <div>
                        @error('first_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 mb-4">
                    <x-input label="Příjmení" wire:model="editForm.last_name" />
                    <div>
                        @error('last_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12  mb-4">
                    <x-choices-offline label="Uživatelská role" :options="$userRoles" wire:model="editForm.userRoleId"
                        single searchable />
                </div>
                <div class="col-span-12 xl:col-span-3 mb-4">
                    <x-checkbox label="Upozornění při změněně kanálu" wire:model="editForm.notify_if_channel_change" />
                </div>
                <div class="col-span-12 xl:col-span-3 mb-4">
                    <x-checkbox label="Upozornění na nový článek ve wiki" wire:model="editForm.notify_if_added_new_wiki_content" />
                </div>
                <div class="col-span-12 xl:col-span-3 mb-4">
                    <x-checkbox label="Upozornění na problém s počasím" wire:model="editForm.notify_if_weather_problem" />
                </div>
                <div class="col-span-12 xl:col-span-3 mb-4">
                    <x-checkbox label="Upozornění na příliš mnoho nefunkčních kanálů"
                        wire:model="editForm.notify_if_too_many_channels_down" />
                </div>
                <div class="col-span-12 xl:col-span-3 mb-4">
                    <x-checkbox label="Upozornění na expirace satelitních karet"
                        wire:model="editForm.notify_if_satelit_card_has_expiration" />
                </div>
                <div class="col-span-12 xl:col-span-3  mb-4">
                    <x-checkbox label="Upozornění na novou událost v kalendáři" wire:model="editForm.notify_if_added_new_event" />
                </div>

                <div class="col-span-12 mb-4">
                    <x-checkbox label="Připnout PopUp okno s výpadky kanálů"
                        wire:model="editForm.iptv_monitoring_window" />
                </div>
            </div>
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
