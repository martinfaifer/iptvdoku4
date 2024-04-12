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
                        'bg-sky-950' => request()->is(
                            'settings/nangu/isps-channel-packages-to-tags'),
                    ]) href="/settings/nangu/isps-channel-packages-to-tags" wire:navigate>
                        <a>
                            <x-heroicon-s-user-group class="size-4" />
                            Správa balíčků
                        </a>
                    </li>

                </ul>
            </details>
        </li>
        <li>
            <details open>
                <summary class="font-semibold ml-1">
                    <x-heroicon-o-adjustments-vertical class="size-4" />
                    GeniusTV
                </summary>
                <ul>
                    <li>
                        <details open>
                            <summary class="font-semibold ml-1">
                                <x-heroicon-o-chart-pie class="size-4" />
                                Statistiky
                            </summary>
                            <ul>
                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/statistics/hbo'),
                                ]) href="/settings/geniustv/statistics/hbo" wire:navigate>
                                    <a>
                                        <x-heroicon-o-chart-pie class="size-4" />
                                        HBO
                                    </a>
                                </li>
                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/statistics/channels'),
                                ]) href="/settings/geniustv/statistics/channels"
                                    wire:navigate>
                                    <a>
                                        <x-heroicon-o-chart-pie class="size-4" />
                                        Kanály
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                </ul>
                {{-- taxes --}}
                <ul>
                    <li>
                        <details open>
                            <summary class="font-semibold ml-1">
                                <x-heroicon-o-currency-dollar class="size-4" />
                                Poplatky
                            </summary>
                            <ul>
                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/static-taxes'),
                                ]) href="/settings/geniustv/static-taxes" wire:navigate>
                                    <a>
                                        <x-heroicon-o-currency-dollar class="w-4 h-4" />
                                        Statické poplatky
                                    </a>
                                </li>

                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/channels-taxes'),
                                ]) href="/settings/geniustv/channels-taxes" wire:navigate>
                                    <a>
                                        <x-heroicon-o-currency-dollar class="size-4" />
                                        Poplatky za kanály
                                    </a>
                                </li>
                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/channel-packages'),
                                ]) href="/settings/geniustv/channel-packages"
                                    wire:navigate>
                                    <a>
                                        <x-heroicon-o-currency-dollar class="size-4" />
                                        Poplatky za balíčky
                                    </a>
                                </li>
                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/offer-taxes'),
                                ]) href="/settings/geniustv/offer-taxes" wire:navigate>
                                    <a>
                                        <x-heroicon-o-currency-dollar class="size-4" />
                                        Poplatky za offery
                                    </a>
                                </li>
                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/discounts'),
                                ]) href="/settings/geniustv/discounts" wire:navigate>
                                    <a>
                                        <x-heroicon-o-currency-dollar class="size-4" />
                                        Slevy
                                    </a>
                                </li>
                                <li @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' => request()->is('settings/geniustv/invoices'),
                                ]) href="/settings/geniustv/invoices" wire:navigate>
                                    <a>
                                        <x-heroicon-o-currency-dollar class="size-4" />
                                        Faktury
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </details>
        </li>
    </ul>
</div>
