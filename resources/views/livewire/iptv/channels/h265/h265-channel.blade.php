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
            </div>
        @endif
    </div>
    @if (!empty($h265))
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-6 mb-4">
                <x-share.cards.base-card title="Informace o unicastu">
                    {{-- list of multicast datas --}}
                    @foreach ($h265 as $unicast)
                        <div class="flex flex-col gap-4 sm:grid sm:grid-cols-12 font-semibold text-[#A3ABB8]">
                            <div class="flex justify-between sm:col-span-12">
                                <p>
                                    <span class="font-normal">
                                        {{ $unicast['quality']['name'] }}p:
                                    </span>
                                    <span class="ml-3">
                                        {{ $unicast['ip'] }}
                                    </span>
                                    <span class="ml-3 font-thin text-xs italic">
                                        {{ $unicast['quality']['bitrate'] }}kbps
                                    </span>
                                    @if ($this->isInIptvDohledDohled($unicast['ip']))
                                        <span>
                                            <x-badge class="bg-green-800 rounded-md text-white text-xs italic"
                                                value="Dohleduje se" />
                                        </span>
                                    @endif
                                </p>
                                <div class="sm:col-span-1 -mt-2">
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
                <livewire:notes.note-component column="h265_id" id="{{ $channel->h265->id }}">
            </div>
            <div class="col-span-12 md:col-span-6 mb-4">
                <livewire:log-component columnValue="h265:{{ $channel->id }}" column="item">
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
                            <div class="col-span-12 md:col-span-6 mb-4">
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
                            <div class="col-span-6 mb-4">
                                <livewire:iptv.channels.device-has-channel-component :device="$backupDevice" :channel="$channel"
                                    isBackup="true" channelType="h265">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
