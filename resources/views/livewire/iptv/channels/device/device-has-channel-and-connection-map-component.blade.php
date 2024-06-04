<div>
    @if (!$devices->isEmpty())
        <div class="col-span-12 mb-4">
            <div class="flex">
                <hr
                    class="w-1/2 h-[1px] mt-2 mr-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                <span class="text-xs italic">
                    @if ($isBackup == false)
                        Primár
                    @else
                        Backup
                    @endif
                </span>
                <hr
                    class="w-1/2 h-[1px] mt-2 ml-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
            </div>
        </div>


        <div class="navbar">
            {{-- create new channel --}}
            <div class="flex-1">

            </div>
            <div class="flex-none">
                <div class="tooltip tooltip-left" data-tip="Zobrazit / skrýt mapu">
                    <x-button class="btn-sm bg-transparent border-none" icon="o-cube-transparent"
                        wire:click='showOrHideDeviceConnectionMap()'></x-button>
                </div>
            </div>
        </div>


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
                <div wire:key="device_{{ $device->id }}" class="col-span-12 xl:col-span-6 mb-4">
                    <livewire:iptv.channels.device-has-channel-component wire:key="device_component_{{ $device->id }}"
                        :device="$device" :channel="$channel" :isBackup="$isBackup" :channelType="$channelType" lazy>
                </div>
            @endforeach

        </div>
    @endif
</div>
