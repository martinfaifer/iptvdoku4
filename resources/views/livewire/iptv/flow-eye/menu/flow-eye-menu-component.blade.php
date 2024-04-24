<div>
    <ul class="menu w-60">
        @foreach (array_reverse($flowEyeNavigation['data']) as $ticket)
            {{-- {{ dd($ticket['current_step']['inbox']) }} --}}
            <li @class([
                'ml-1',
                'rounded-lg',
                'bg-sky-950' => request()->is('floweye/' . $ticket['id']),
            ]) href="/floweye/{{ $ticket['id'] }}" wire:navigate><a>
                    {{ strip_tags($ticket['current_step']['inbox']) }}
                </a></li>
            <hr
                class="w-full h-[1px] mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
        @endforeach
    </ul>
</div>
