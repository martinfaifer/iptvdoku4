<div>
    {{-- create multicast channel if not exists --}}
    <div class="navbar bg-transparent">
        <div class="flex-1">
            @if ($multicasts->isEmpty())
                <livewire:iptv.channels.multicast.store-multicast-channel :channel="$channel">
            @endif
        </div>
        @if (!$multicasts->isEmpty())
            <div class="md:flex-none gap-2 md:overflow-x-auto">
                <livewire:iptv.channels.multicast.store-multicast-channel :channel="$channel">
                    <livewire:iptv.channels.store-device-to-channel-component :channel="$channel" channelType="multicast">
            </div>
        @endif
    </div>
    @if (!$multicasts->isEmpty())
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-4">
                <x-share.cards.base-card title="Informace o multicastu">
                    {{-- list of multicast datas --}}
                    @foreach ($multicasts as $multicast)
                        <div class="flex flex-col gap-4 sm:grid sm:grid-cols-12 font-semibold">
                            <div class="col-span-12 sm:col-span-3">
                                <div class="lg:flex">
                                    <p>
                                        <span class="font-normal">
                                            Zdrojová IP:
                                        </span>
                                        <span class="ml-3">
                                            {{ $multicast->source_ip }}
                                        </span>
                                        @if ($this->isInIptvDohledDohled($multicast->source_ip))
                                            <x-badge class="bg-green-800 rounded-md text-white text-xs italic"
                                                value="Dohleduje se" />
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-3 sm:inline-flex">
                                <p>
                                    <span class="font-normal">
                                        Zdroj:
                                    </span>
                                    <span class="ml-3">
                                        {{ $multicast->channel_source->name }}
                                    </span>
                                </p>
                            </div>
                            <div class="sm:col-span-3 col-span-12">
                                <div class="lg:flex">
                                    <p>
                                        <span class="font-normal">
                                            STB IP:
                                        </span>
                                        <span class="ml-3">
                                            {{ $multicast->stb_ip }}
                                        </span>
                                        @if ($this->isInIptvDohledDohled($multicast->stb_ip))
                                            <x-badge class="bg-green-800 rounded-md text-white text-xs italic"
                                                value="Dohleduje se" />
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <p>
                                    <span class="font-normal">
                                        Typ:
                                    </span>
                                    <span class="ml-3">
                                        @if ($multicast->is_backup)
                                            <span class="text-orange-500">
                                                Záloha
                                            </span>
                                        @else
                                            <span class="text-green-500">
                                                Primár
                                            </span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div class="col-span-12 sm:col-span-1 -mt-2">
                                <button class="btn btn-sm btn-circle bg-transparent border-none"
                                    wire:click='edit({{ $multicast->id }})'>
                                    <x-heroicon-m-pencil class="w-4 h-4 text-green-500" />
                                </button>
                                <button class="btn btn-sm btn-circle bg-transparent border-none"
                                    wire:click='destroy({{ $multicast->id }})' wire:confirm="Opravdu odebrat?">
                                    <x-heroicon-m-trash class="w-4 h-4 text-red-500" />
                                </button>
                            </div>
                        </div>
                        <x-share.lines.small-hr></x-share.lines.small-hr>
                    @endforeach
                </x-share.cards.base-card>
                {{-- edit dialog --}}
                <x-modal wire:model="updateModal" title="Změna multicastu" persistent
                    class="modal-bottom sm:modal-middle fixed">
                    <x-form wire:submit="update">
                        <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                            wire:click='closeModal'>✕</x-button>
                        <div class="grid grid-cols-12 gap-4">
                            {{-- name --}}
                            <div class="col-span-12 mb-4">
                                <x-input label="IP k STB" wire:model="form.stb_ip" />
                                <div>
                                    @error('stb_ip')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- logo --}}
                            <div class="col-span-12 mb-4">
                                <x-input label="Zdrojová IP" wire:model="form.source_ip" />
                                <div>
                                    @error('source_ip')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- qualities --}}
                            <div class="col-span-12 mb-4">
                                <x-choices label="Zdroj" wire:model="form.channel_source_id" :options="$channelSources"
                                    single />
                                <div>
                                    @error('channel_source_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- is_backup --}}
                            <div class="col-span-6 mb-4">
                                <x-toggle label="Záloha" wire:model="form.is_backup" />
                                <div>
                                    @error('is_backup')
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
            <div class="col-span-12 md:col-span-6">
                <livewire:notes.note-component column="channel_id" :id="$channel->id" />
            </div>
            <div class="col-span-12 md:col-span-6 mb-4">
                <livewire:log-component columnValue="multicast:{{ $channel->id }}" column="item" />
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
                                    channelType="multicast">
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
                            <div class="col-span-12 md:col-span-6 mb-4">
                                <livewire:iptv.channels.device-has-channel-component :device="$backupDevice" :channel="$channel"
                                    isBackup="true" channelType="multicast">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- iptvdohled section --}}
            @foreach ($multicasts as $multicast)
                <div class="col-span-12 mb-4 gap-4">
                    <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component
                        ip="{{ $multicast->source_ip }}">
                </div>
                <div class="col-span-12 mb-4 gap-4">
                    <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component
                        ip="{{ $multicast->stb_ip }}">
                </div>
            @endforeach

        </div>
    @endif
</div>
