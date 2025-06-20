<div wire.poll.5s>
    {{-- @dd($channelRegion->region->name) --}}
    <div class="tooltip tooltip-left absolute mt-7 md:mt-6 md:right-10 shadow-none border-none" data-tip="informace o kanálu">
        <label @click='$wire.openChannelDetailDrawer' class="btn btn-sm bg-transparent border-none shadow-none" label="Bottom"
            tooltip-bottom="Detail o kanálu">
            <x-heroicon-o-information-circle class="w-6 h-6 text-sky-500" />
        </label>
    </div>
    {{-- info drawer --}}
    <x-drawer wire:model='channelDetailDrawer' separator right class="lg:w-1/4 dark:!bg-[#0E1E33]">
        <div class="lg:hidden">
            <x-button class="btn btn-sm btn-circle btn-ghost bg-[#0E1E33] absolute right-2 top-2"
                @click='$wire.channelDetailDrawer = false'>✕</x-button>
        </div>
        {{-- informations about channel quality, category, description --}}
        <div>
            <div class="col-span-12 mb-2">
                <div class="flex">
                    <hr
                        class="w-1/2 h-[1px] mt-2 mr-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                    <span class="text-xs italic">GeniusTV</span>
                    <hr
                        class="w-1/2 h-[1px] mt-2 ml-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                </div>
                <div class="flex gap-4 mt-7">
                    @foreach ($channelPackages as $channelPackage)
                        <div class="tooltip" data-tip="Balíček ve kterém je kanál">
                            <div
                                class="text-xs inline-flex items-center font-semibold px-3 py-1 bg-sky-800 text-[#fff] rounded-lg w-18 h-6">
                                {{ $channelPackage }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="col-span-12 mb-2">
                <div class="flex">
                    <hr
                        class="w-1/2 h-[1px] mt-2 mr-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                    <span class="text-xs italic">
                        Informace
                    </span>
                    <hr
                        class="w-1/2 h-[1px] mt-2 ml-12 my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                </div>
            </div>
            <div class="flex gap-4 mt-7">
                {{-- quality --}}
                <div class="tooltip" data-tip="Kvalita ve které se vysílá">
                    <div
                        class="text-xs inline-flex items-center px-3 py-1 bg-sky-800 text-[#fff] font-semibold rounded-lg w-18 h-6">
                        {{ $channel->quality }}
                    </div>
                </div>

                <div class="tooltip" data-tip="Žánr">
                    <div
                        class="text-xs inline-flex items-center font-semibold px-3 py-1 bg-sky-800 text-[#fff] rounded-lg w-18 h-6">
                        {{ $channel->channelCategory?->name }}
                    </div>
                </div>

                @if ($epg != '')
                    <div class="tooltip" data-tip="EPG">
                        <div
                            class="text-xs inline-flex items-center font-semibold px-3 py-1 bg-sky-800 text-[#fff] rounded-lg w-18 h-6">
                            {{ $epg }}
                        </div>
                    </div>
                @endif

                <div class="tooltip" data-tip="Region">
                    <div
                        class="text-xs inline-flex items-center font-semibold px-3 py-1 bg-sky-800 text-[#fff] rounded-lg w-18 h-6">
                        Region <span class="font-bold ml-1"> {{ $channel->region?->name }}</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-4">
            <div>
                <article class="text-wrap">
                    <p class="text-sm italic">{{ $channel->description }}</p>
                </article>
            </div>
        </div>
        @if (!is_null($channel->channelProgramer))
            <hr
                class="w-full h-[1px] mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
            <div class="mt-4 subpixel-antialiased">
                <p class="font-semibold">Informace o programeru {{ $channel->channelProgramer->name }}</p>
                @if (!blank($channelProgrammer->channelProgramer->contacts))
                    @foreach ($channelProgrammer->channelProgramer->contacts as $contact)
                        <div class="grid grid-cols-12 gap-2 my-2 mx-2 text-sm">
                            <div class="col-span-12">
                                <div class="inline-flex">
                                    <x-heroicon-o-user class="w-4 h-4" />
                                    <span class="ml-2">
                                        Osoba:
                                    </span>
                                    <span class="ml-4">
                                        {{ $contact->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-span-12">
                                <div class="inline-flex">
                                    <x-heroicon-o-envelope class="w-4 h-4" />
                                    <span class="ml-2">
                                        email:
                                    </span>
                                    <span class="ml-4">
                                        <a class="text-blue-500 hover:underline" href="mailto:{{ $contact->email }}">
                                            {{ $contact->email }}
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-span-12">
                                <div class="inline-flex">
                                    <x-heroicon-o-phone class="w-4 h-4" />
                                    <span class="ml-2">
                                        telefon:
                                    </span>
                                    <span class="ml-4">
                                        <a class="text-blue-500 hover:underline" href="tel:{{ $contact->phone }}">
                                            {{ $contact->phone }}
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
        <hr
            class="w-full h-[1px] mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
        <div class="mt-4 subpixel-antialiased">
            <p class="font-semibold">Informace o kanálu z NanguTv</p>
            <ul class="list-disc list-outside ml-4 text-sm">
                @foreach ($nanguChannelDetail as $nanguChannelKey => $nanguChannelDetail)
                    @if (!is_array($nanguChannelDetail))
                        <li class="mt-2">
                            <span class="font-normal">
                                {{ $nanguChannelKey }} :
                            </span>
                            <span class="font-semibold">
                                @if (is_bool($nanguChannelDetail))
                                    @if ($nanguChannelDetail == true)
                                        <span class="text-green-500">
                                            povoleno
                                        </span>
                                    @else
                                        <span class="text-red-500">
                                            zakázano
                                        </span>
                                    @endif
                                @else
                                    {{ $nanguChannelDetail }}
                                @endif
                            </span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </x-drawer>
</div>
