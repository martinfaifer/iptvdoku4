<div>
    <div class="tooltip tooltip-left absolute mt-6 right-8" data-tip="informace o kanálu">
        <label for="channel-detail-drawer" class="btn btn-sm bg-transparent border-none" label="Bottom" tooltip-bottom="Joe">
            <x-heroicon-o-information-circle class="w-6 h-6 text-sky-500" />
        </label>
    </div>
    {{-- info drawer --}}
    <x-drawer id="channel-detail-drawer" separator right class="lg:w-1/4 !bg-[#0A0F19]">
        {{-- informations about channel quality, category, description --}}
        <div class="flex gap-4 mt-7">
            <div class="tooltip" data-tip="Kvalita ve které se vysílá">
                <div
                    class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-sky-800 text-sky-200 rounded-lg w-18 h-6">
                    {{ $channel->quality }}
                </div>
            </div>

            <div class="tooltip" data-tip="Žánr">
                <div
                    class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-sky-800 text-sky-200 rounded-lg w-18 h-6">
                    {{ $channel->channelCategory->name }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div>
                <article class="text-wrap">
                    <p class="font-semibold">Popis kanálu</p>
                    <p class="text-sm italic">{{ $channel->description }}</p>
                </article>
            </div>
        </div>
        <hr
            class="w-full h-[1px] mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
        <div class="mt-4 subpixel-antialiased">
            <p class="font-semibold">Informace o kanálu z NanguTv</p>
            <ul class="list-disc list-outside ml-4 text-sm">
                @foreach ($nanguChannelDetail as $nanguChannelKey => $nanguChannelDetail)
                    @if (!is_array($nanguChannelDetail))
                        <li>
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
