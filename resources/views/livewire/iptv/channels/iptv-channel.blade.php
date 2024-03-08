<div>
    <div class="flex flex-col">
        {{-- create new channel --}}
        <div class="relative">
            <div class="absolute left">
                <livewire:iptv.channels.store-channel />
            </div>
            <div class="flex justify-center">
                @if (!is_null($channel) && !is_null($channel->name))
                    <ul class="menu menu-vertical lg:menu-horizontal bg-transparent rounded-box">

                        <li href="/channels/{{ $channel->id }}/multicast" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#282C39]' => request()->is('channels/' . $channel->id . '/multicast'),
                        ])><a>
                                multicast</a></li>

                        <li href="/channels/{{ $channel->id }}/h264" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#282C39]' => request()->is('channels/' . $channel->id . '/h264'),
                        ])><a>
                                H264</a></li>

                        <li href="/channels/{{ $channel->id }}/h265" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#282C39]' => request()->is('channels/' . $channel->id . '/h265'),
                        ])><a>
                                H265</a></li>

                    </ul>
                @endif
            </div>
        </div>
        {{-- show alert about no channel found --}}
        @if (is_null($channel) || is_null($channel->name))
            <div class="mt-12">
                <x-share.alerts.info title="Vyberte kanál z menu vlevo"></x-share.alerts.info>
            </div>
        @else
            {{-- tags --}}
            <div>
                <livewire:tag-component type="channel" itemId="{{ $channel->id }}"></livewire:tag-component>
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-1 mt-4">
                    @if (!is_null($channel->logo))
                        <img class="object-cover w-16 h-12" src="/storage/{{ str_replace('public/', '', $channel->logo) }}"
                            alt="" />
                    @endif
                </div>
                <div class="col-span-11 flex">
                    <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                        {{ $channel->name }}
                    </h1>
                    @if ($channel->is_radio == true)
                        <div
                            class="ml-4 mt-7 text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-sky-800 text-sky-200 rounded-lg w-18 h-6">
                            rádio
                        </div>
                    @endif

                    {{-- actions --}}
                    <livewire:iptv.channels.update-channel :channel="$channel"></livewire:iptv.channels.update-channel>
                    <livewire:iptv.channels.delete-channel :channel="$channel"></livewire:iptv.channels.delete-channel>
                    {{-- end of actions --}}

                    {{-- info section --}}
                    <livewire:iptv.channels.channel-detail :channel="$channel"></livewire:iptv.channels.channel-detail>
                    {{-- end of info section --}}
                    {{-- end of update modal --}}
                </div>
            </div>
            <hr
                class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-none rounded">
            <div ">
                {{-- split to multicast , h264, h265 --}}
                {{-- multicast --}}
                  @if (request()->is('channels/' . $channel->id . '/multicast'))
                <livewire:iptv.channels.multicast.multicast-channel :channel="$channel">
        @endif
        {{-- h264 --}}
        @if (request()->is('channels/' . $channel->id . '/h264'))
            <livewire:iptv.channels.h264.h264-channel :channel="$channel">
        @endif
        {{-- h265 --}}
        @if (request()->is('channels/' . $channel->id . '/h265'))
            <livewire:iptv.channels.h265.h265-channel :channel="$channel">
        @endif
    </div>
    @endif
</div>
</div>
