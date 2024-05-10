<div>
    <div class="navbar bg-transparent">
        <div class="flex-1">
            @if (is_null($channel->h265))
                <livewire:iptv.channels.h265.store-h265-channel :channel="$channel">
            @endif
        </div>
        @if (!is_null($channel->h265))
            <div class="flex-none">
                <livewire:iptv.channels.h265.store-h265-channel :channel="$channel">
                    <livewire:iptv.channels.store-device-to-channel-component :channel="$channel" channelType="h265">
            </div>
        @endif
    </div>
    @if (!empty($h265))
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-6 mb-4">
                <x-share.cards.base-card title="Informace o unicastu">
                    @foreach ($h265 as $unicast)
                        <div class="grid grid-cols-12 gap-4 text-white/80 font-semibold text-[#A3ABB8]">
                            <div class="col-span-12">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-10">
                                        <p>
                                            <span class="font-normal">
                                                {{ $unicast['quality']['name'] }}p:
                                            </span>
                                            <span @class([
                                                'ml-3',
                                                'text-green-500' => $this->isInIptvDohledDohled($unicast['ip']),
                                            ])>
                                                {{ $unicast['ip'] }}
                                            </span>
                                            <span class="ml-3 font-thin text-xs italic">
                                                {{ $unicast['quality']['bitrate'] }}kbps
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-span-2 -mt-2">
                                        <button class="btn btn-sm btn-circle bg-transparent border-none"
                                            wire:click='edit({{ $unicast['id'] }})'>
                                            <x-heroicon-m-pencil class="w-4 h-4 text-green-500" />
                                        </button>
                                        <button class="btn btn-sm btn-circle bg-transparent border-none"
                                            wire:click='destroy({{ $unicast['id'] }})' wire:confirm="Opravdu odebrat?">
                                            <x-heroicon-m-trash class="w-4 h-4 text-red-500" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr
                            class="sm:hidden w-full h-[1px] mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                    @endforeach
                </x-share.cards.base-card>
                {{-- edit dialog --}}
                <x-modal wire:model="updateModal" title="Změna ip u kvality" persistent
                    class="modal-bottom sm:modal-middle fixed">
                    <x-form wire:submit="update">
                        <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                            wire:click='closeModal'>✕</x-button>
                        <div class="grid grid-cols-12 gap-4">
                            {{-- name --}}
                            <div class="col-span-12 mb-4">
                                <x-input label="Kvalita {{ $quality }}" wire:model="form.ip" />
                                <div>
                                    @error('ip')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if ($form->isInDohled)
                                <div class="col-span-6 mb-4">
                                    <x-toggle label="Odebrat z dohledu" wire:model="form.delete_from_dohled" />
                                    <div>
                                        @error('delete_from_dohled')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if (!$form->isInDohled)
                                <div class="col-span-6 mb-4">
                                    <x-toggle label="Přidat do dohledu" wire:model="form.to_dohled" />
                                    <div>
                                        @error('to_dohled')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{-- action section --}}
                        <div class="flex justify-between">
                            <div>
                                <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                                    wire:click='closeModal' />
                            </div>
                            <div>
                                <x-button label="Změnit"
                                    class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                                    type="submit" spinner="save2" />
                            </div>
                        </div>
                    </x-form>

                </x-modal>
            </div>
            <div class="col-span-12 md:col-span-6 mb-4">
                {{--  --}}
            </div>
            <div class="col-span-12 md:col-span-6 mb-4">
                <livewire:notes.note-component column="h265_id" id="{{ $channel->h265->id }}" lazy>
            </div>
            <div class="col-span-12 md:col-span-6 mb-4">
                <livewire:log-component columnValue="h265:{{ $channel->id }}" column="item" lazy>
            </div>
            @if (!$devices->isEmpty())
                <div class="col-span-12 mb-4">
                    <div class="flex">
                        <hr
                            class="w-1/2 h-[1px] mt-2 mr-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                        <span class="text-xs italic">Primár</span>
                        <hr
                            class="w-1/2 h-[1px] mt-2 ml-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <div class="grid grid-cols-12 gap-4">
                        @foreach ($devices as $device)
                            <div wire:key="source-{{ $device->id }}" class="col-span-12 md:col-span-6 mb-4">
                                <livewire:iptv.channels.device-has-channel-component :device="$device" :channel="$channel"
                                    channelType="h265">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (!$backupDevices->isEmpty())
                <div class="col-span-12 mb-4">
                    <div class="flex">
                        <hr
                            class="w-1/2 h-[1px] mt-2 mr-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                        <span class="text-xs italic">Backup</span>
                        <hr
                            class="w-1/2 h-[1px] mt-2 ml-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <div class="grid grid-cols-12 gap-4">
                        @foreach ($backupDevices as $backupDevice)
                            <div wire:key="backup-{{ $backupDevice->id }}" class="col-span-6 mb-4">
                                <livewire:iptv.channels.device-has-channel-component :device="$backupDevice" :channel="$channel"
                                    isBackup="true" channelType="h265">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @foreach ($h265 as $unicast)
                <div wire:key="unicast-{{ $unicast['ip'] }}" class="col-span-12 mb-4 gap-4">
                    <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component
                        ip="{{ $unicast['ip'] }}">
                </div>
            @endforeach
        </div>
    @endif
</div>
