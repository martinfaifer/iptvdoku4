<div class=" overflow-hidden">
    <div class="flex flex-col">
        {{-- create new channel --}}
        <div class="relative">
            <div class="absolute left">
                @can('create', $channel)
                    <livewire:iptv.channels.store-channel />
                @endcan
            </div>
            <div class="flex justify-center">
                @if (!is_null($channel) && !is_null($channel->name))
                    <ul class="menu menu-horizontal bg-transparent rounded-box -mt-2 menu-sm xl:menu-md">

                        <li href="/channels/{{ $channel->id }}/multicast" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#1C3D56]' => request()->is('channels/' . $channel->id . '/multicast'),
                        ])><a>
                                multicast</a></li>

                        <li href="/channels/{{ $channel->id }}/h264" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#1C3D56]' => request()->is('channels/' . $channel->id . '/h264'),
                        ])><a>
                                H264</a></li>

                        <li href="/channels/{{ $channel->id }}/h265" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#1C3D56]' => request()->is('channels/' . $channel->id . '/h265'),
                        ])><a>
                                H265</a></li>

                        @if (!is_null($channel->epg_id))
                            <li href="/channels/{{ $channel->id }}/epg" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1C3D56]' => request()->is('channels/' . $channel->id . '/epg'),
                            ])><a>
                                    EPG</a></li>
                        @endif

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
                <livewire:tag-component type="channel" itemId="{{ $channel->id }}"></livewire:tag-component lazy>
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-1 mt-4">
                    @if (!is_null($channel->logo))
                        <img class="object-contain w-16 h-12"
                            src="/storage/{{ str_replace('public/', '', $channel->logo) }}" alt="" />
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
                    @can('update', $channel)
                        <livewire:iptv.channels.update-channel :channel="$channel"></livewire:iptv.channels.update-channel>
                    @endcan
                    @can('delete', $channel)
                        <livewire:iptv.channels.delete-channel :channel="$channel"></livewire:iptv.channels.delete-channel>
                    @endcan
                    {{-- end of actions --}}
                    <div class="hidden md:block absolute md:mt-7 md:right-32" data-tip="informace o kanálu">
                        <div
                            class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-cyan-500 text-neutral-200 rounded-md w-18 h-6">
                            <div class="inline-flex">
                                timeshift {{ $this->getTimeShiftTime() }} dní
                            </div>
                        </div>
                    </div>
                    <livewire:iptv.channels.channel-detail :channel="$channel"></livewire:iptv.channels.channel-detail
                        lazy>
                </div>
            </div>
            <hr
                class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-none rounded">
            <div>
                {{-- split to multicast , h264, h265 --}}
                {{-- multicast --}}
                @if (request()->is('channels/' . $channel->id . '/multicast'))
                    <livewire:iptv.channels.multicast.multicast-channel :channel="$channel" lazy>
                @endif
                {{-- h264 --}}
                @if (request()->is('channels/' . $channel->id . '/h264'))
                    <livewire:iptv.channels.h264.h264-channel :channel="$channel" lazy>
                @endif
                {{-- h265 --}}
                @if (request()->is('channels/' . $channel->id . '/h265'))
                    <livewire:iptv.channels.h265.h265-channel :channel="$channel" lazy>
                @endif

                @if (request()->is('channels/' . $channel->id . '/epg'))
                <livewire:iptv.channels.epg.epg-channel-component :channel="$channel" lazy>
            @endif
            </div>
        @endif
    </div>
</div>
