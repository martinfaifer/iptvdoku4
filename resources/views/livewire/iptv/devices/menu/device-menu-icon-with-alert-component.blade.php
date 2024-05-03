<div class="tooltip tooltip-right" data-tip="{{ $dataType }}">
    <li href="/devices" wire:navigate @class([
        'rounded-lg',
        'bg-[#1A1E2A]' => request()->is('devices') || request()->is('devices/*'),
    ])>
        <a>
            <x-sui-flip-view class="size-6 text-white" fill="none" />
            @if ($isAlert)
                <div class="text-white text-xs bg-red-500 rounded-full absolute size-4 ml-4 mt-3">
                    <span class="ml-[6px]">
                        !
                    </span>
                </div>
            @endif
        </a>
    </li>
</div>
