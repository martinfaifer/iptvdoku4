<div wire:poll>
    <div class="tooltip tooltip-bottom" data-tip="Iptv dohled">
        <li href="/iptv-monitoring" wire:navigate.hover @class([
            'rounded-lg',
            'bg-[#1A1E2A]' =>
                request()->is('iptv-monitoring') || request()->is('iptv-monitoring/*'),
        ])>
            <a>
                <x-heroicon-o-tv class="size-6 text-white/80" fill="none" />
                @if ($numberOfAlerts != 0)
                    {{-- <div class="text-white text-xs bg-red-500 rounded-full absolute size-5 ml-4 mt-3"> --}}
                    <span class="mt-1 fixed text-red-500 font-bold bg-black/10 rounded-full z-auto ml-6">
                        @if ($numberOfAlerts > 9)
                            9+
                        @else
                            {{ $numberOfAlerts }}
                        @endif
                    </span>
                    {{-- </div> --}}
                @endif
            </a>
        </li>
    </div>
</div>
