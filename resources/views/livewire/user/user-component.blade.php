<div>
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <h1 class="text-2xl dark:text-white/80 subpixel-antialiased font-bold mt-6 ">
                Přehled
            </h1>
        </div>
    </div>
    <hr class="w-full h-[1px] dark:h-1 mt-2 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-none rounded">
    <div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <div wire:click='openAvatarDialog()'
                    class="mt-6 rounded-full size-32 bg-black flex items-center justify-center cursor-pointer">
                    @if (is_null($user->avatar_url))
                        <div class="text-white/90 text-4xl font-semibold">
                            {{ $user->first_name[0] }}
                            {{ $user->last_name[0] }}
                        </div>
                    @else
                        <img class="object-contain rounded-full" src="{{ config('app.url') . '/' . $user->avatar_url }}""
                            alt="" />
                    @endif
                </div>
            </div>
            {{-- information about user --}}
            <div class="col-span-12 mt-6">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-6">
                        <div class="text-xl font-semibold">
                            Informace o Vás <x-button wire:click='openEditUserDialog()'
                                class="bg-transparent btn-xs text-green-500 border-none shadow-none">
                                <x-heroicon-o-pencil class="size-4" />
                            </x-button>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 xl:mt-12">
                        <p class="mt-1 font-semibold">Jméno: {{ Auth::user()->first_name }}</p>
                        <p class="mt-4 font-semibold">Příjmení: {{ Auth::user()->last_name }}</p>
                        <p class="mt-4 font-semibold">Email: {{ Auth::user()->email }}</p>
                        <p class="mt-4 font-semibold">Oprávnění: {{ Auth::user()->userRole->name }}</p>
                    </div>
                </div>
                <hr
                    class="w-full h-[1px] mt-4 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-0 rounded">
            </div>
            {{-- logged devices sessions --}}
            <div class="col-span-12 mt-6">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-6">
                        <div class="text-xl font-semibold">
                            Přihlášená zařízení
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 xl:mt-12">
                        @if (!empty($userSessions))
                            <div class="grid grid-cols-12 gap-4">
                                @foreach ($userSessions as $agent)
                                    <div class="col-span-12">
                                        <div
                                            class="bg-slate-800/5 dark:bg-[#0f172a]/50 backdrop-blur-xl shadow-sm dark:shadow-md dark:shadow-[#0D243C]/50 rounded-lg">
                                            <div class="card-body dark:text-gray-200 text-sm">
                                                <div class="grid grid-cols-12 gap-2">
                                                    <div class="col-span-2">
                                                        @if ($agent['device']['isDesktop'])
                                                            <x-heroicon-o-computer-desktop class="size-12" />
                                                        @endif
                                                        @if ($agent['device']['isMobile'])
                                                            <x-heroicon-o-device-phone-mobile class="size-12" />
                                                        @endif
                                                    </div>
                                                    <div class="col-span-6">
                                                        <p> {{ $agent['device']['platform'] }} -
                                                            {{ $agent['device']['browser'] }}</p>

                                                        <p class="mt-2"> {{ $agent['ip_address'] }}</p>
                                                        <p class="mt-2"> {{ $agent['last_active'] }}</p>
                                                    </div>
                                                    <div class="col-span-4">
                                                        <div class="flex justify-center items-center">
                                                            <x-button wire:click="session_destroy({{ $agent['id'] }})"
                                                                wire:submit='Opravdu odebrat?'
                                                                class="btn-sm bg-transparent border-none text-red-500"
                                                                icon="o-trash"></x-button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-span-12">
                                    <x-button wire:click='sessions_destroy()' label="Odebrat všechny zařízení"
                                        class="btn btn-doku-primary w-full" />
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <hr
                    class="w-full h-[1px] mt-4 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-0 rounded">
            </div>
            {{-- change password --}}
            <div class="col-span-12 mt-6">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-6">
                        <div class="text-xl font-semibold">
                            Změna hesla
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 xl:mt-12">
                        <x-form wire:submit="changePassword">
                            <x-input label="Nové heslo" wire:model="changeUserPasswordForm.password" />
                            <x-input label="Nové heslo ještě jednou" wire:model="changeUserPasswordForm.newpassword" />
                            <div>
                                <x-button label="Změnit heslo"
                                    class="btn btn-doku-primary w-full"
                                    spinner="changePassword"
                                    type="submit" />
                            </div>
                        </x-form>
                    </div>
                </div>
                <hr
                    class="w-full h-[1px] mt-4 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-0 rounded">
            </div>
            {{-- pin iptv monitoring window --}}
            <div class="col-span-12 mt-6">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-6">
                        <div class="text-xl font-semibold">
                            Připnout PopUp okno s výpadky kanálů
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 xl:mt-12">
                        <x-form wire:submit="pinIptvWindow()">
                            <x-checkbox label="Připnout" wire:model="isPinned" />

                            <div>
                                <x-button label="Potvrdit"
                                    class="btn btn-doku-primary w-full"
                                    type="submit" />
                            </div>

                        </x-form>
                    </div>
                </div>
                <hr
                    class="w-full h-[1px] mt-4 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-0 rounded">
            </div>
        </div>
    </div>

    {{-- dialogs --}}
    <x-modal wire:model="avatarDialog" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="upload_avatar">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-file label="Avatar" wire:model="avatarForm.avatar" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    @if (!is_null($user->avatar_url))
                        <x-button label="Odebrat"
                            class="btn btn-doku-close w-full sm:w-28"
                            wire:click='deleteAvatar()' spinner="upload" />
                    @endif
                    <x-button label="Nahrát"
                        class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="upload" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="editUserDialog" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="Jméno" wire:model="userEditForm.first_name" />
                </div>
                <div class="col-span-12">
                    <x-input label="Příjmení" wire:model="userEditForm.last_name" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28"
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
