<div>
    <ul class="menu w-60" wire:scroll>
        @foreach ($channels as $channel)
            <li wire:key='channel_{{ $channel->id }}' @class([
                'ml-1',
                'rounded-lg',
                'bg-sky-950' => request()->is('channels/' . $channel->id . '/*'),
            ])
                href="/channels/{{ $channel->id }}/multicast" wire:navigate>
                <a class="grid grid-cols-12">
                    <div class="col-span-2">
                        @if ($channel->is_radio == true)
                            <div class="tooltip tooltip-bottom " data-tip="rádio">
                                <x-icon name="o-radio" class="inline-flex items-center w-4 h-4 -mt-1" />
                            </div>
                        @endif
                    </div>
                    <div class="col-span-2">
                        @if (!is_null($channel->logo))
                            <img class="w-6 h-6" src="/storage/{{ str_replace('public/', '', $channel->logo) }}"
                                alt="" />
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
