<div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 xl:col-span-10">
            <div class="h-96 xl:h-[48rem] overflow-auto">
                @foreach ($epg['programmes']['programme'] as $epg_program)
                    <x-list-item :item="$epg_program" no-separator no-hover
                        @class(['bg-blue-500/20' => $this->isTimeBetween($epg_program['start'], $epg_program['stop']) == 'running-channel' ])
                        id="{{ $this->isTimeBetween($epg_program['start'], $epg_program['stop']) }}">
                        <x-slot:avatar>
                            <div class="flex flex-col text-sm text-blue-400">
                                <div>
                                    {{ $this->stringTimeParseToTime($epg_program['start']) }}
                                </div>
                                <div>
                                    {{ $this->stringTimeParseToTime($epg_program['stop']) }}
                                </div>
                            </div>
                        </x-slot:avatar>
                        <x-slot:value class="text-xl">
                            {{ $epg_program['title'] }}
                        </x-slot:value>
                        <x-slot:sub-value>
                            <div class="grid grid-cols-12 gap-4">
                                @if (array_key_exists('descriptions', $epg_program))
                                    <div class="col-span-12">
                                        <p class="text-wrap">
                                            {{ $epg_program['descriptions']['desc'] }}
                                        </p>
                                    </div>
                                @endif
                                @if (array_key_exists('photos', $epg_program))
                                    <div class="col-span-12">
                                        <div class="grid grid-cols-12">
                                            @foreach ($epg_program['photos']['photo'] as $img)
                                                @if (isset($img['url']))
                                                    <img class="object-contain w-16 h-12" src="{{ $img['url'] }}"
                                                        alt="">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </x-slot:sub-value>
                    </x-list-item>
                @endforeach
            </div>

        </div>
        <div class="col-span-12 xl:col-span-2">
            <x-input type="date" wire:model.live="dayInMonth" wire:change="$dispatch('reload_channel_epg')" />
        </div>
    </div>
</div>
@script
    <script>
        setTimeout(() => {
            document
                .getElementById('running-channel')
                .scrollIntoView({});
        }, 500);
    </script>
@endscript
