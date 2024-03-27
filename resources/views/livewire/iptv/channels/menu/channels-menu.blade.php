<div>
    <ul class="menu w-60" wire:scroll>
        @foreach ($channels as $channel)
            <li id="channel_{{ $channel->id }}" wire:key='channel_{{ $channel->id }}' @class([
                'ml-1',
                'rounded-lg',
                'bg-sky-950' => request()->is('channels/' . $channel->id . '/*'),
            ])
                href="/channels/{{ $channel->id }}/multicast" wire:navigate>
                <a class="grid grid-cols-12">
                    <div class="col-span-2">
                        @if (!is_null($channel->logo))
                            <img class="object-contain size-6"
                                src="/storage/{{ str_replace('public/', '', $channel->logo) }}" alt="" />
                        @endif
                    </div>
                    <div class="col-span-2">
                        @if ($channel->is_radio == true)
                            <div class="tooltip tooltip-bottom " data-tip="rádio">
                                <x-icon name="o-radio"
                                    class="inline-flex items-center w-4 h-4 -mt-1 text-orange-500/50" />
                            </div>
                        @endif
                    </div>
                    <div class="col-span-8 font-semibold">
                        {{ $channel->name }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>

@script
    <script>
        let url = window.location.href;
        let parsedUrl = url.split("/");
        let lastTwo = parsedUrl.slice(-2)

        document
            .getElementById('channel_' + lastTwo.slice(-2, 1))
            .scrollIntoView({});
    </script>
@endscript
