<div>
    <div class="tooltip tooltip-bottom" data-tip="FlowEye">
        <li href="/floweye" wire:navigate @class([
            'rounded-lg',
            'bg-[#1A1E2A]' => request()->is('floweye') || request()->is('floweye/*'),
        ])>
            <a>
                <x-heroicon-o-viewfinder-circle class="size-6 text-white/80" fill="none" />
                @if ($numberOfAlerts != 0)
                    <div class="text-white text-xs bg-red-500 rounded-full absolute size-4 ml-4 mt-3">
                        <span class="ml-1 font-semibold">
                            {{ $numberOfAlerts }}
                        </span>
                    </div>
                @endif
            </a>
        </li>
    </div>
</div>
