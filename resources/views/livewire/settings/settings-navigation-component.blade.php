<div>
    <ul class="menu w-60">
        <li @class([
            'ml-1',
            'rounded-lg',
            'bg-slate-800/5 dark:bg-sky-950' => request()->is('settings/dashboard'),
        ]) href="/settings/dashboard" wire:navigate><a>
                <x-heroicon-o-square-3-stack-3d class="size-4" />
                Přehled
            </a></li>

        @can('show_settings_tags', App\Models\User::class)
            <li @class([
                'ml-1',
                'rounded-lg',
                'bg-slate-800/5 dark:bg-sky-950' => request()->is('settings/tags'),
            ]) href="/settings/tags" wire:navigate><a>
                    <x-heroicon-o-tag class="w-4 h-4" />
                    Štítky
                </a></li>
        @endcan
        @can('show_settings_users', App\Models\User::class)
            <li @class([
                'ml-1',
                'rounded-lg',
                'bg-slate-800/5 dark:bg-sky-950' => request()->is('settings/users'),
            ]) href="/settings/users" wire:navigate><a>
                    <x-heroicon-o-user-group class="w-4 h-4" />
                    Uživatelé
                </a>
            </li>
        @endcan
        @can('show_settings_logs', App\Models\User::class)
            <li @class([
                'ml-1',
                'rounded-lg',
                'bg-slate-800/5 dark:bg-sky-950' => request()->is('settings/logs'),
            ]) href="/settings/logs" wire:navigate><a>
                    <x-heroicon-o-document-magnifying-glass class="size-4" />
                    Logy
                </a>
            </li>
        @endcan
        @can('show_settings_devices', App\Models\User::class)
            <li>
                <details open>
                    <summary class="font-semibold ml-1">
                        <x-heroicon-o-device-tablet class="size-4" />
                        Zařízení
                    </summary>
                    <ul>
                        <li @class([
                            'ml-1',
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                'settings/devices/vendors'),
                        ]) href="/settings/devices/vendors" wire:navigate><a>
                                <x-heroicon-o-device-tablet class="size-4" />
                                Výrobci zařízení
                            </a></li>
                        <li @class([
                            'ml-1',
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                'settings/devices/distributors'),
                        ]) href="/settings/devices/distributors" wire:navigate><a>
                                <x-heroicon-o-credit-card class="size-4" />
                                Distributoři sat. caret
                            </a></li>
                        <li @class([
                            'ml-1',
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                'settings/devices/templates/gpu-modules'),
                        ]) href="/settings/devices/templates/gpu-modules" wire:navigate><a>
                                <x-heroicon-o-computer-desktop class="size-4" />
                                Šablony GPU
                            </a></li>
                    </ul>
                </details>
            </li>
        @endcan
        @can('show_settings_notifications', App\Models\User::class)
            <li>
                <details open>
                    <summary class="font-semibold ml-1">
                        <x-heroicon-o-bell class="size-4" />
                        Upozornění
                    </summary>
                    <ul>
                        <li @class([
                            'ml-1',
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                'settings/notifications/slack'),
                        ]) href="/settings/notifications/slack" wire:navigate><a>
                                <x-heroicon-o-bell-alert class="size-4" />
                                Slack
                            </a></li>
                        <li @class([
                            'ml-1',
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                'settings/notifications/weather'),
                        ]) href="/settings/notifications/weather" wire:navigate><a>
                                <x-heroicon-o-sun class="size-4" />
                                Počasí
                            </a></li>
                    </ul>
                </details>
            </li>
        @endcan
        @can('show_settings_channels', App\Models\User::class)
            <li>
                <details open>
                    <summary class="font-semibold ml-1">
                        <x-heroicon-o-tv class="size-4" />
                        Kanály
                    </summary>
                    <ul>
                        @can('show_settings_channels_restart', App\Models\User::class)
                            <li @class([
                                'ml-1',
                                'rounded-lg',
                                'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                    'settings/channels/restart'),
                            ]) href="/settings/channels/restart" wire:navigate><a>
                                    <x-heroicon-o-arrow-path class="size-4" />
                                    Automatický restart
                                </a></li>
                        @endcan
                        @can('show_settings_channels_banners', App\Models\User::class)
                            <li @class([
                                'ml-1',
                                'rounded-lg',
                                'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                    'settings/channels/banners'),
                            ]) href="/settings/channels/banners" wire:navigate><a>
                                    <x-heroicon-o-photo class="size-4" />
                                    Nahrané bannery
                                </a></li>
                        @endcan
                        @can('show_settings_channels_multicast_sources', App\Models\User::class)
                            <li @class([
                                'ml-1',
                                'rounded-lg',
                                'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                    'settings/channels/multicats/sources'),
                            ]) href="/settings/channels/multicats/sources" wire:navigate><a>
                                    <x-heroicon-o-window class="size-4" />
                                    Zdroje multicastů
                                </a></li>
                        @endcan
                        @can('show_channels_programers', App\Models\User::class)
                            <li @class([
                                'ml-1',
                                'rounded-lg',
                                'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                    'settings/channels/programmers'),
                            ]) href="/settings/channels/programmers" wire:navigate><a>
                                    <x-heroicon-o-users class="size-4" />
                                    Programeři
                                </a></li>
                        @endcan
                        @can('show_channels_programers', App\Models\User::class)
                            <li @class([
                                'ml-1',
                                'rounded-lg',
                                'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                    'settings/channels/qualities'),
                            ]) href="/settings/channels/qualities" wire:navigate><a>
                                    <x-heroicon-o-tv class="size-4" />
                                    Kvality
                                </a></li>
                        @endcan
                    </ul>
                </details>
            </li>
        @endcan
        @can('show_settings_nangu', App\Models\User::class)
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
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is('settings/nangu/isps'),
                        ]) href="/settings/nangu/isps" wire:navigate><a>
                                <x-heroicon-o-tv class="w-4 h-4" />
                                ISP
                            </a></li>

                        <li @class([
                            'ml-1',
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                'settings/nangu/isps-channel-packages-to-tags'),
                        ]) href="/settings/nangu/isps-channel-packages-to-tags"
                            wire:navigate>
                            <a>
                                <x-heroicon-o-user-group class="size-4" />
                                Správa balíčků
                            </a>
                        </li>

                    </ul>
                </details>
            </li>
        @endcan

        @can('show_settings_geniustv', App\Models\User::class)
            <li>
                <details open>
                    <summary class="font-semibold ml-1">
                        <x-heroicon-o-adjustments-vertical class="size-4" />
                        GeniusTV
                    </summary>
                    <ul>
                        <li @class([
                            'ml-1',
                            'rounded-lg',
                            'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                'settings/geniustv/tv-channel-packages'),
                        ]) href="/settings/geniustv/tv-channel-packages" wire:navigate>
                            <a>
                                <x-heroicon-o-tv class="size-4" />
                                TV balíčky
                            </a>
                        </li>
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
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/statistics/hbo'),
                                    ]) href="/settings/geniustv/statistics/hbo"
                                        wire:navigate>
                                        <a>
                                            <x-heroicon-o-chart-pie class="size-4" />
                                            HBO grafy
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/statistics/channels'),
                                    ]) href="/settings/geniustv/statistics/channels"
                                        wire:navigate>
                                        <a>
                                            <x-heroicon-o-chart-pie class="size-4" />
                                            Kanály
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/statistics/offers'),
                                    ]) href="/settings/geniustv/statistics/offers"
                                        wire:navigate>
                                        <a>
                                            <x-heroicon-o-chart-pie class="size-4" />
                                            Offery
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/statistics/programers'),
                                    ]) href="/settings/geniustv/statistics/programers"
                                        wire:navigate>
                                        <a>
                                            <x-heroicon-o-chart-pie class="size-4" />
                                            Programeři
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/statistics/hbo-stats'),
                                    ]) href="/settings/geniustv/statistics/hbo-stats"
                                        wire:navigate>
                                        <a>
                                            <x-heroicon-o-chart-pie class="size-4" />
                                            HBO
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/statistics/max-stats'),
                                    ]) href="/settings/geniustv/statistics/max-stats"
                                        wire:navigate>
                                        <a>
                                            <x-heroicon-o-chart-pie class="size-4" />
                                            Balík MAX
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/statistics/plus-or-film-stats'),
                                    ])
                                        href="/settings/geniustv/statistics/plus-or-film-stats" wire:navigate>
                                        <a>
                                            <x-heroicon-o-chart-pie class="size-4" />
                                            Balík PLUS / FILM
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
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/static-taxes'),
                                    ]) href="/settings/geniustv/static-taxes" wire:navigate>
                                        <a>
                                            <x-heroicon-o-currency-dollar class="w-4 h-4" />
                                            Statické poplatky
                                        </a>
                                    </li>

                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/channels-taxes'),
                                    ]) href="/settings/geniustv/channels-taxes"
                                        wire:navigate>
                                        <a>
                                            <x-heroicon-o-currency-dollar class="size-4" />
                                            Poplatky za kanály
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/channel-packages'),
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
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/offer-taxes'),
                                    ]) href="/settings/geniustv/offer-taxes" wire:navigate>
                                        <a>
                                            <x-heroicon-o-currency-dollar class="size-4" />
                                            Poplatky za offery
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/discounts'),
                                    ]) href="/settings/geniustv/discounts" wire:navigate>
                                        <a>
                                            <x-heroicon-o-currency-dollar class="size-4" />
                                            Slevy
                                        </a>
                                    </li>
                                    <li @class([
                                        'ml-1',
                                        'rounded-lg',
                                        'bg-slate-800/5 dark:bg-sky-950' => request()->is(
                                            'settings/geniustv/invoices'),
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
        @endcan
    </ul>
</div>
