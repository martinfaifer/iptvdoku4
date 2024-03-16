<div>
    <ul class="menu w-60">
        <li @class([
            'ml-1',
            'rounded-lg',
            'bg-sky-950' => request()->is('settings/tags'),
        ]) href="/settings/tags" wire:navigate><a>
                <x-heroicon-s-tag class="w-4 h-4" />
                Štítky
            </a></li>
        <li @class([
            'ml-1',
            'rounded-lg',
            'bg-sky-950' => request()->is('settings/users'),
        ]) href="/settings/users" wire:navigate><a>
                <x-heroicon-o-user-group class="w-4 h-4" />
                Uživatelé
            </a></li>
        <li>
            <details open>
                <summary class="font-semibold ml-1">
                    <x-heroicon-o-inbox-stack class="size-4" />
                    Nangu
                </summary>
                <ul>
                    <li @class([
                        'ml-1',
                        'rounded-lg',
                        'bg-sky-950' => request()->is('settings/nangu/isps'),
                    ]) href="/settings/nangu/isps" wire:navigate><a>
                            <x-heroicon-s-tv class="w-4 h-4" />
                            ISP
                        </a></li>

                    <li @class([
                        'ml-1',
                        'rounded-lg',
                        'bg-sky-950' => request()->is('settings/nangu/isps-channel-packages-to-tags'),
                    ]) href="/settings/nangu/isps-channel-packages-to-tags" wire:navigate><a>
                            <x-heroicon-s-user-group class="size-4"/>
                            Správa balíčků
                        </a></li>

                </ul>
            </details>
        </li>
    </ul>
</div>
