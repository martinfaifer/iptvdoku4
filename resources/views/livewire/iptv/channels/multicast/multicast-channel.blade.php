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
                <livewire:iptv.channels.multicast.info-multicast-channel-component
                    :channel="$channel"></livewire:iptv.channels.multicast.info-multicast-channel-component>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-6 xl:col-span-4">
                <livewire:notes.note-component column="channel_id" :id="$channel->id" lazy />
            </div>
            <div class="col-span-12 md:col-span-6  lg:col-span-6 xl:col-span-4">
                <livewire:contact-component type="channel" :item_id="$channel->id" lazy />
            </div>
            @can('operate_with_childs', App\Models\Channel::class)
                <div class="col-span-12 xl:col-span-4 mb-4">
                    <livewire:log-component columnValue="multicast:{{ $channel->id }}" column="item" lazy />
                </div>
            @endcan
            @can('operate_with_childs', App\Models\Channel::class)
                <div class="col-span-12 mb-4">
                    <livewire:iptv.channels.device.device-has-channel-and-connection-map-component :channel="$channel"
                        channelType="multicast">
                </div>

                <div class="col-span-12 mb-4">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 mb-4">
                            <livewire:iptv.channels.device.device-has-channel-and-connection-map-component :channel="$channel"
                                isBackup="true" channelType="multicast">
                        </div>
                    </div>
                </div>
            @endcan

            {{-- iptvdohled section --}}
            @can('operate_with_childs', App\Models\Channel::class)
                @foreach ($multicasts as $multicast)
                    <div wire:key='iptvDohled_{{ $multicast->source_ip }}' class="col-span-12 mb-4 gap-4">
                        <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component
                            ip="{{ $multicast->source_ip }}" lazy>
                    </div>
                    <div wire:key='iptvDohled_{{ $multicast->stb_ip }}' class="col-span-12 mb-4 gap-4">
                        <livewire:iptv.channels.iptv-dohled.channel-data-on-iptv-dohled-component
                            ip="{{ $multicast->stb_ip }}" lazy>
                    </div>
                @endforeach
            @endcan
        </div>
    @endif
</div>
