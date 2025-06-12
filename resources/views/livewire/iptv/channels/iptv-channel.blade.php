<div class=" overflow-hidden">
    <div class="flex flex-col">
        {{-- create new channel --}}
        <div class="relative">
            <div class="absolute left">
                {{-- @can('create', $channel) --}}
                <livewire:iptv.channels.store-channel lazy />
                {{-- @endcan --}}
            </div>
            <div class="flex justify-center">
                @if (!is_null($channel) && !is_null($channel->name))
                    <ul class="menu menu-horizontal bg-transparent rounded-box -mt-2 menu-sm xl:menu-md">
                        <li href="/channels/{{ $channel->id }}/multicast" wire:navigate.hover
                            @class([
                                'rounded-lg',
                                'bg-slate-800/5 dark:bg-[#1C3D56]' => request()->is(
                                    'channels/' . $channel->id . '/multicast'),
                            ])><a>
                                multicast</a></li>

                        <li href="/channels/{{ $channel->id }}/h264" wire:navigate.hover @class([
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-[#1C3D56]' => request()->is(
                                'channels/' . $channel->id . '/h264'),
                        ])>
                            <a>
                                H264</a>
                        </li>

                        <li href="/channels/{{ $channel->id }}/h265" wire:navigate.hover @class([
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-[#1C3D56]' => request()->is(
                                'channels/' . $channel->id . '/h265'),
                        ])>
                            <a>
                                H265</a>
                        </li>

                        @if (!blank($channel->epg_id))
                            <li href="/channels/{{ $channel->id }}/epg" wire:navigate @class([
                                'rounded-lg',
                                'bg-slate-800/5 dark:bg-[#1C3D56]' => request()->is(
                                    'channels/' . $channel->id . '/epg'),
                            ])><a>
                                    EPG</a></li>
                        @endif

                        <li @class(['rounded-lg'])>
                            <div class="dropdown dropdown-bottom">
                                <div tabindex="0" class="rounded-none border-none bg-transparent">Nástroje
                                    <x-heroicon-c-chevron-down class="size-4 inline-block" />
                                </div>
                                <ul tabindex="0"
                                    class="dropdown-content menu dark:bg-[#0D1E33] rounded-box border-none z-[1] w-52 p-2 shadow-none dark:shadow-sm">
                                    <li><a href="/channels/{{ $channel->id }}/streams-analyze" wire:navigate>Analýza
                                            streamů</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
        {{-- show alert about no channel found --}}
        @if (is_null($channel) || is_null($channel->name))
            <div class="absolute left">
                {{-- @can('create', $channel) --}}
                <livewire:iptv.channels.store-channel lazy />
                {{-- @endcan --}}
            </div>
            <div class="mt-12">
                <x-share.alerts.info title="Vyberte kanál z menu vlevo" lazy />
            </div>
        @else
            {{-- tags --}}
            <div>
                <livewire:tag-component type="channel" itemId="{{ $channel->id }}" lazy />
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-1 mt-4">
                    @if (!is_null($channel->logo))
                        {{-- add download option --}}
                        <div class="tooltip tooltip-right" data-tip="kliknutím stáhnete logo">
                            <img class="object-contain w-16 h-12 cursor-pointer" wire:click='downloadLogo()'
                                wire:confirm='Přejete si stáhnout logo?'
                                src="/storage/{{ str_replace('public/', '', $channel->logo) }}" alt="" />
                        </div>
                    @endif
                </div>
                <div class="col-span-11 flex">
                    <h1 class="text-2xl text-[#27272a] dark:text-white/80 subpixel-antialiased font-bold mt-6 ">
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
                        <livewire:iptv.channels.update-channel :channel="$channel" lazy />
                    @endcan
                    @can('delete', $channel)
                        <livewire:iptv.channels.delete-channel :channel="$channel" lazy />
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
                    <livewire:iptv.channels.channel-detail :channel="$channel" lazy />
                </div>
            </div>
            <hr
                class="w-full h-[1px] dark:h-1 mt-2 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-none rounded">
            <div>
                @if (request()->is('channels/' . $channel->id . '/multicast'))
                    <livewire:iptv.channels.multicast.multicast-channel :channel="$channel" />
                @endif

                @if (request()->is('channels/' . $channel->id . '/h264'))
                    <livewire:iptv.channels.h264.h264-channel :channel="$channel" />
                @endif

                @if (request()->is('channels/' . $channel->id . '/h265'))
                    <livewire:iptv.channels.h265.h265-channel :channel="$channel" />
                @endif

                @if (request()->is('channels/' . $channel->id . '/epg'))
                    <livewire:iptv.channels.epg.epg-channel-component :channel="$channel" lazy />
                @endif

                @if (request()->has('stream_url'))
                    <livewire:iptv.channels.notification.channel-notification-component
                        ip="{{ request()->get('stream_url') }}" lazy />
                @endif

                @if (request()->is('channels/' . $channel->id . '/streams-analyze'))
                    <livewire:iptv.channels.tools.stream-analyze-component :channel="$channel" lazy />
                @endif
            </div>
        @endif
    </div>
</div>
