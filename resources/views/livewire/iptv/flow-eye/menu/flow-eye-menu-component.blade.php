<div>
    <ul class="menu w-60">
        @if (array_key_exists('data', $flowEyeNavigation))
            @foreach (array_reverse($flowEyeNavigation['data']) as $ticket)
                <li @class([
                    'ml-1',
                    'rounded-lg',
                    'bg-slate-800/5 dark:bg-sky-950' => request()->is('floweye/' . $ticket['id']),
                ]) href="/floweye/{{ $ticket['id'] }}" wire:navigate><a>
                        @if (!array_key_exists('resitel', $ticket))
                            <hr
                                class="w-[1px] h-full mt-2 my-1 bg-gradient-to-r from-red-950 to-red-500 border-0 rounded-lg">
                        @endif
                        {{ strip_tags($ticket['current_step']['inbox']) }}
                    </a></li>
                <hr
                    class="w-full h-[1px] mt-2 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-0 rounded">
            @endforeach
        @else
            {{--  --}}
        @endif
    </ul>
</div>
