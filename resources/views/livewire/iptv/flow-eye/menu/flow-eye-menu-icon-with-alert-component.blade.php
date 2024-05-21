<div>
    <div class="tooltip tooltip-bottom" data-tip="FlowEye">
        <li href="/floweye" wire:navigate.hover @class([
            'rounded-lg',
            'bg-[#1A1E2A]' => request()->is('floweye') || request()->is('floweye/*'),
        ])>
            <a>
                <x-heroicon-o-viewfinder-circle class="size-6 text-white/80" fill="none" />
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
