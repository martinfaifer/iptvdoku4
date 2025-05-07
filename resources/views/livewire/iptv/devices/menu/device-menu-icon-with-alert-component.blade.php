<div class="tooltip tooltip-bottom" data-tip="{{ $dataType }}">
    <li href="/devices" wire:navigate.hover @class([
        'rounded-lg',
        'bg-[#1E1D1E] dark:bg-[#1A1E2A]' => request()->is('devices') || request()->is('devices/*'),
    ])>
        <a>
            <x-sui-flip-view class="size-6 text-white" fill="none" />
            @if ($isAlert)
                <span @class([
                    'mt-1 text-lg font-bold fixed text-red-500 z-auto ml-6 hover:bg-[#171D2B]',
                ])>
                    !
                </span>
            @endif
        </a>
    </li>
</div>
