<div>
    <div class="navbar bg-transparent">
        @can('operate_with_childs', App\Models\Channel::class)
            <div class="flex-1">
                @if (is_null($channel->h264))
                    <livewire:iptv.channels.h264.store-h264-channel :channel="$channel" lazy>
                @endif
            </div>
            @if (!is_null($channel->h264))
                <div class="flex-none gap-2">
                    <livewire:iptv.channels.h264.store-h264-channel :channel="$channel" lazy>
                        <livewire:iptv.channels.store-device-to-channel-component :channel="$channel" channelType="h264" lazy>
                </div>
            @endif
        @endcan
    </div>
    @if (!empty($h264))
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 xl:col-span-6 mb-4">
                <x-share.cards.base-card title="Informace o unicastu" >
                    {{-- list of multicast datas --}}
                    @foreach ($h264 as $unicast)
                        <div class="grid grid-cols-12 gap-4 dark:text-white/80 font-semibold">
                            <div class="col-span-12">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-10 flex">
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
                                        <x-share.btns.copy-btn dataToCopy="{{ $unicast['ip'] }}" />
                                    </div>
                                    <div class="col-span-2 -mt-1">
                                        @can('operate_with_childs', App\Models\Channel::class)
                                            @if ($this->isInIptvDohledDohled($unicast['ip']))
                                                <div class="tooltip tooltip-bottom" data-tip="Upozornění na výpadky">
                                                    <button class="btn btn-sm btn-circle bg-transparent border-none"
                                                        href="/channels/{{ $channel->id }}/notifications?stream_url={{ $unicast['ip'] }}"
                                                        wire:navigate>
                                                        <x-heroicon-o-bell @class([
                                                            'w-4 h-4',
                                                            'text-green-500' => $this->can_notify($unicast['ip']),
                                                            'text-slate-500' => !$this->can_notify($unicast['ip']),
                                                        ]) />
                                                    </button>
                                                </div>
                                            @endif
                                            <button class="btn btn-sm btn-circle bg-transparent border-none"
                                                @click='$wire.edit({{ $unicast['id'] }})'>
                                                <x-heroicon-m-pencil class="w-4 h-4 text-green-500" />
                                            </button>
                                            <button class="btn btn-sm btn-circle bg-transparent border-none"
                                                wire:click='destroy({{ $unicast['id'] }})' wire:confirm="Opravdu odebrat?">
                                                <x-heroicon-m-trash class="w-4 h-4 text-red-500" />
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr
                            class="sm:hidden w-full h-[1px] mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                    @endforeach
                </x-share.cards.base-card>
                {{-- edit dialog --}}
                <x-modal wire:model="updateModal" persistent
                    class="modal-bottom sm:modal-middle fixed">
                    <x-form wire:submit="update">
                        <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                            @click='$wire.closeModal'>✕</x-button>
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
                                <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                                    wire:click='closeModal' />
                            </div>
                            <div>
                                <x-button label="Změnit"
                                    class="btn btn-doku-primary w-full sm:w-28"
                                    type="submit" spinner="update" />
                            </div>
                        </div>
                    </x-form>

                </x-modal>
            </div>
            @can('operate_with_childs', App\Models\Channel::class)
                <div class="col-span-12 xl:col-span-6 mb-4">
                    {{--  --}}
                </div>
            @endcan
            <div class="col-span-12 xl:col-span-6 mb-4">
                <livewire:notes.note-component column="h264_id" id="{{ $channel->h264->id }}" lazy />
            </div>
            @can('operate_with_childs', App\Models\Channel::class)
                <div class="col-span-12 xl:col-span-6 mb-4">
                    <livewire:log-component columnValue="h264:{{ $channel->id }}" column="item" lazy />
                </div>
            @endcan
            @can('operate_with_childs', App\Models\Channel::class)
                <div class="col-span-12 mb-4">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 mb-4">
                            <livewire:iptv.channels.device.device-has-channel-and-connection-map-component :channel="$channel"
                                :isBackup="false" channelType="h264" lazy />
                        </div>
                    </div>
                </div>

                <div class="col-span-12 mb-4">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 mb-4">
                            <livewire:iptv.channels.device.device-has-channel-and-connection-map-component :channel="$channel"
                                :isBackup="true" channelType="h264" lazy />
                        </div>
                    </div>
                </div>
            @endcan

            @can('operate_with_childs', App\Models\Channel::class)
                @foreach ($h264 as $unicast)
                    <div wire:key="unicast-{{ $unicast['ip'] }}" class="col-span-12 mb-4 gap-4">
                        <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component ip="{{ $unicast['ip'] }}"
                            lazy />
                    </div>
                @endforeach
            @endcan
        </div>
    @endif
</div>
