<div>
    @if (count($devices) > 1 || $channelType != 'multicast')
        <div class="navbar">
            {{-- create new channel --}}
            <div class="flex-1">

            </div>
            <div class="flex-none">
                <x-button class="btn-sm bg-transparent border-none" icon="o-cube-transparent"
                    wire:click='showOrHideDeviceConnectionMap()'></x-button>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-12 gap-4">
        @if (count($devices) > 1 || $channelType != 'multicast')
            @if ($isHiddenChannelConnectionMap == false)
                <div class="col-span-12 mb-4">

                    @if ($channelType == 'multicast')
                        <x-share.cards.channel-connection-card :devices="$devices" :channel="$channel"
                            :channelType="$channelType"></x-share.cards.channel-connection-card>
                    @else
                        <x-share.cards.channel-connection-card :devices="$schemaDevices" :channel="$channel"
                            :channelType="$channelType"></x-share.cards.channel-connection-card>
                    @endif
                </div>
            @endif
        @endif

        @foreach ($devices as $device)
            <div wire:key="device_{{ $device->id }}" class="col-span-12 md:col-span-6 mb-4">
                <livewire:iptv.channels.device-has-channel-component wire:key="device_component_{{ $device->id }}"
                    :device="$device" :channel="$channel" :isBackup="$isBackup" :channelType="$channelType" lazy>
            </div>
        @endforeach

    </div>
</div>
