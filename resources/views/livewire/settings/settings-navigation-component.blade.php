<div>
    <ul class="menu w-60">
        <li @class([
            'ml-1',
            'rounded-lg',
            'bg-sky-950' => request()->is('settings/tags'),
        ]) href="/settings/tags" wire:navigate><a>
                <x-heroicon-s-tag class="w-4 h-4"/>
                Štítky
            </a></li>
        <li>
            <details open>
                <summary class="font-semibold">
                    Test
                </summary>
                <ul>
                    <li @class([
                        'ml-1',
                        'rounded-lg',
                        'bg-sky-950' => request()->is('settings/test'),
                    ]) href="/settings/test" wire:navigate><a>
                            test
                        </a></li>

                </ul>
            </details>
        </li>
    </ul>
</div>
