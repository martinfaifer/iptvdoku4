<div>
    {{-- create multicast channel if not exists --}}
    <div class="navbar bg-transparent">
        <div class="flex-1">
            @if ($multicasts->isEmpty())
                @can('create', $channel)
                    <livewire:iptv.channels.multicast.store-multicast-channel :channel="$channel" />
                @endcan
            @endif
        </div>
        @if (!$multicasts->isEmpty())
            <div class="md:flex-none gap-2 md:overflow-x-auto">
                @can('operate_with_childs', App\Models\Channel::class)
                    <livewire:iptv.channels.multicast.store-multicast-channel :channel="$channel" />
                @endcan
                @can('operate_with_childs', App\Models\Channel::class)
                    <livewire:iptv.channels.store-device-to-channel-component :channel="$channel" channelType="multicast" />
                @endcan
            </div>
        @endif
    </div>
    @if (!$multicasts->isEmpty())
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-4">
                <x-share.cards.base-card title="Informace o multicastu">
                    {{-- list of multicast datas --}}
                    @foreach ($multicasts as $multicast)
                        <div wire:key='multicast_{{ $multicast->id }}'
                            class="grid grid-cols-12 font-semibold text-[#A3ABB8]">
                            <div class="col-span-12 md:col-span-3">
                                <p>
                                    <span class="font-normal">
                                        Zdrojová IP:
                                    </span>
                                    <span @class([
                                        'ml-3',
                                        'text-green-500' => $this->isInIptvDohledDohled($multicast->source_ip),
                                    ])>
                                        {{ $multicast->source_ip }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-span-12 md:col-span-3 mt-4 md:mt-0">
                                <p>
                                    <span class="font-normal">
                                        Zdroj:
                                    </span>
                                    <span class="ml-3">
                                        {{ $multicast->channel_source->name }}
                                    </span>
                                </p>
                            </div>
                            <div class="md:col-span-3 col-span-12 mt-4 md:mt-0">
                                <p>
                                    <span class="font-normal">
                                        STB IP:
                                    </span>
                                    <span @class([
                                        'ml-3',
                                        'text-green-500' => $this->isInIptvDohledDohled($multicast->stb_ip),
                                    ])">
                                        {{ $multicast->stb_ip }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-span-12 md:col-span-2 mt-4 md:mt-0">
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
                            <div class="col-span-12 md:col-span-1 mt-4 md:-mt-2">
                                @can('operate_with_childs', App\Models\Channel::class)
                                    <button class="btn btn-sm btn-circle bg-transparent border-none"
                                        wire:click='edit({{ $multicast->id }})'>
                                        <x-heroicon-m-pencil class="w-4 h-4 text-green-500" />
                                    </button>
                                @endcan
                                @can('operate_with_childs', App\Models\Channel::class)
                                    <button class="btn btn-sm btn-circle bg-transparent border-none"
                                        wire:click='destroy({{ $multicast->id }})' wire:confirm="Opravdu odebrat?">
                                        <x-heroicon-m-trash class="w-4 h-4 text-red-500" />
                                    </button>
                                @endcan
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
                            <div class="col-span-12 mb-4">
                                <x-input label="Zdrojová IP" wire:model="form.source_ip" />
                                <div>
                                    @error('source_ip')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
                                    type="submit" spinner="update" />
                            </div>
                        </div>
                    </x-form>
                </x-modal>


            </div>
            <div class="col-span-12 md:col-span-4">
                <livewire:notes.note-component column="channel_id" :id="$channel->id" lazy />
            </div>
            <div class="col-span-12 md:col-span-4">
                <livewire:contact-component type="channel" :item_id="$channel->id" lazy />
            </div>
            @can('operate_with_childs', App\Models\Channel::class)
                <div class="col-span-12 md:col-span-4 mb-4">
                    <livewire:log-component columnValue="multicast:{{ $channel->id }}" column="item" lazy />
                </div>
            @endcan
            @can('operate_with_childs', App\Models\Channel::class)
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
                                    <livewire:iptv.channels.device-has-channel-component
                                        wire:key="device_{{ $device->id }}" :device="$device" :channel="$channel"
                                        channelType="multicast" lazy>
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
                                    <livewire:iptv.channels.device-has-channel-component
                                        wire:key="backupDevice_{{ $device->id }}" :device="$backupDevice" :channel="$channel"
                                        isBackup="true" channelType="multicast" lazy>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endcan

            {{-- iptvdohled section --}}
            @can('operate_with_childs', App\Models\Channel::class)
                @foreach ($multicasts as $multicast)
                    <div class="col-span-12 mb-4 gap-4">
                        <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component
                            wire:key='iptvDohled_{{ $multicast->source_ip }}' ip="{{ $multicast->source_ip }}" lazy>
                    </div>
                    <div class="col-span-12 mb-4 gap-4">
                        <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component
                            wire:key='iptvDohled_{{ $multicast->stb_ip }}' ip="{{ $multicast->stb_ip }}" lazy>
                    </div>
                @endforeach
            @endcan
        </div>
    @endif
</div>
