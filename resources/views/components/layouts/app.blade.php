<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martin Faifer">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" class="text-red-500" href="{{ asset('favicon.svg') }}">
    {{-- <link rel="manifest" href="/site.webmanifest"> --}}
    <title>{{ $title ?? 'IPTV dokumentace' }}</title>
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/diff2html/bundles/css/diff2html.min.css" /> --}}
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/diff2html/bundles/js/diff2html-ui.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/a6yh9ynf4jozp4fh5ifm4ge2jyxhqtpzbisgvawi52igqueb/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link href="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/vanilla-calendar.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/themes/light.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/themes/dark.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar@2.7.0/build/vanilla-calendar.min.js" defer>
    </script>

    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/umd/photoswipe.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/umd/photoswipe-lightbox.umd.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/photoswipe.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #unsupported-browser {
            display: none;
            background-color: red;
            color: white;
            padding: 20px;
            text-align: center;
            position: fixed;
            top: 0;
            z-index: 99999;
            left: 0;
            width: 100%;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-[#f6f7f9] dark:bg-gradient-to-r from-slate-900 to-sky-950 ">
    <x-toast />
    @auth
        <x-spotlight search-text="Vyhledejte ... " no-results-text="Ops! Nenalezeno." class="justify-center"
            shortcut="ctrl.space" />
        {{-- show alerts --}}
        <livewire:alert-component>

            {{-- pinned trashed channels from iptv dohled --}}
            <div class="">
                <livewire:iptv-monitoring.iptv-monitoring-component />
            </div>
            {{-- end pinned --}}
        @endauth

        <x-main sticky full-width>
            @auth
                @persist('sidebar-menu')
                    <x-slot:sidebar drawer="sidebar-drawer"
                        class="dark:bg-gradient-to-b from-slate-950/80 to-black/50 border-r border-[#64748b] border-opacity-10 !w-[320px]">

                        <x-menu activate-by-route active-bg-color="bg-slate-800 dark:bg-sky-950" class="-ml-4 -mt-2 ">
                            <ul
                                class="menu bg-[#252425] dark:bg-[#020411]/20 border-r border-[#64748b] border-opacity-10 h-full ml-2 fixed">
                                <div class="tooltip tooltip-bottom" data-tip="Kanály">
                                    <li href="/channels" wire:navigate.hover @class([
                                        'rounded-lg',
                                        'bg-[#1E1D1E] dark:bg-[#1A1E2A]' =>
                                            request()->is('channels') || request()->is('channels/*'),
                                    ])>
                                        <a>
                                            <x-sui-tv-mode class="size-6 text-white" fill="none" />
                                        </a>
                                    </li>
                                </div>
                                @can('show_blade_functions', App\Model\Device::class)
                                    <livewire:iptv.devices.menu.device-menu-icon-with-alert-component />
                                @endcan
                                @can('show_blade_functions', App\Model\SatelitCard::class)
                                    <div class="tooltip tooltip-bottom" data-tip="Satelitní karty">
                                        <li href="/sat-cards" wire:navigate.hover @class([
                                            'rounded-lg',
                                            'bg-[#1E1D1E] dark:bg-[#1A1E2A]' =>
                                                request()->is('sat-cards') || request()->is('sat-cards/*'),
                                        ])>
                                            <a>
                                                <x-heroicon-o-credit-card class="size-6 text-white/80" fill="none" />
                                            </a>
                                        </li>
                                    </div>
                                @endcan
                                @can('show_blade_functions', App\Models\Event::class)
                                    <div class="tooltip tooltip-bottom" data-tip="Kalendář">
                                        <li href="/calendar" wire:navigate.hover @class([
                                            'rounded-lg',
                                            'bg-[#1E1D1E] dark:bg-[#1A1E2A]' =>
                                                request()->is('calendar') || request()->is('calendar/*'),
                                        ])>
                                            <a>
                                                <x-heroicon-o-calendar-days class="size-6 text-white/80" fill="none" />
                                            </a>
                                        </li>
                                    </div>
                                @endcan
                                @can('show_servers', App\Models\SftpServer::class)
                                    <div class="tooltip tooltip-bottom" data-tip="Sftp servery">
                                        <li href="/sftps" wire:navigate.hover @class([
                                            'rounded-lg',
                                            'bg-[#1E1D1E] dark:bg-[#1A1E2A]' =>
                                                request()->is('sftps') || request()->is('sftps/*'),
                                        ])>
                                            <a>
                                                <x-heroicon-o-arrow-up-on-square-stack class="size-6 text-white/80"
                                                    fill="none" />
                                            </a>
                                        </li>
                                    </div>
                                @endcan
                                <div class="tooltip tooltip-bottom" data-tip="Wiki">
                                    <li href="/wiki" wire:navigate.hover @class([
                                        'rounded-lg',
                                        'bg-[#1E1D1E] dark:bg-[#1A1E2A]' =>
                                            request()->is('wiki') || request()->is('wiki/*'),
                                    ])>
                                        <a>
                                            <x-heroicon-o-academic-cap class="size-6 text-white/80" fill="none" />
                                        </a>
                                    </li>
                                </div>
                                @can('show_ip_prefixes', App\Models\User::class)
                                    <div class="tooltip tooltip-bottom" data-tip="Ip prefixy">
                                        <li href="/prefixes" wire:navigate.hover @class([
                                            'rounded-lg',
                                            'bg-[#1E1D1E] dark:bg-[#1A1E2A]' =>
                                                request()->is('prefixes') || request()->is('prefixes/*'),
                                        ])>
                                            <a>
                                                <x-heroicon-o-rectangle-stack class="size-6 text-white/80" fill="none" />
                                            </a>
                                        </li>
                                    </div>
                                @endcan
                                @can('show_tickets', App\Models\User::class)
                                    <livewire:iptv.flow-eye.menu.flow-eye-menu-icon-with-alert-component />
                                @endcan
                                {{-- <div class="tooltip tooltip-bottom" data-tip="IPTV Promo">
                                    <li href="/iptv-promo" wire:navigate.hover @class([
                                        'rounded-lg',
                                        'bg-[#1E1D1E] dark:bg-[#1A1E2A]' =>
                                            request()->is('iptv-promo') || request()->is('iptv-promo/*'),
                                    ])>
                                        <a>
                                            <x-heroicon-o-gift class="size-6 text-white/80" fill="none" />
                                        </a>
                                    </li>
                                </div> --}}

                                <li class="rounded-lg fixed bottom-2">
                                    <a>
                                        <x-theme-toggle class="text-white" />
                                    </a>
                                </li>
                            </ul>
                        </x-menu>

                        {{-- main dynamic navigation --}}
                        <x-menu activate-by-route active-bg-color="bg-sky-950" class="ml-16 fixed !h-[99%]">
                            <div class="overflow-y-scroll hover:overflow-y-scroll">
                                @if (request()->is('/') || request()->is('channels') || request()->is('channels/*'))
                                    <livewire:iptv.channels.menu.channels-menu />
                                @endif

                                @if (request()->is('devices') || request()->is('devices/*'))
                                    <livewire:iptv.devices.menu.devices-menu class="fixed" />
                                @endif
                                @if (request()->is('sat-cards') || request()->is('sat-cards/*'))
                                    <livewire:iptv.cards.menu.satelit-cards-menu class="fixed" />
                                @endif
                                @if (request()->is('sftps') || request()->is('sftps/*'))
                                    <livewire:iptv.sftps.menu.sftps-menu class="fixed" />
                                @endif
                                @if (request()->is('wiki') || request()->is('wiki/*'))
                                    <livewire:wiki.menu.wiki-menu-component class="fixed" />
                                @endif
                                @if (request()->is('floweye') || request()->is('floweye/*'))
                                    <livewire:iptv.flow-eye.menu.flow-eye-menu-component class="fixed" />
                                @endif
                                @if (request()->is('profile') || request()->is('profile/*'))
                                    <livewire:user.menu.user-menu-component class="fixed" />
                                @endif
                                @if (request()->is('prefixes') || request()->is('prefixes/*'))
                                    <livewire:nangu.ip-prefixes.menu.menu-nangu-ip-prefixes-component class="fixed" />
                                @endif
                                @if (request()->is('settings') || request()->is('settings/*'))
                                    <livewire:settings.settings-navigation-component class="fixed" />
                                @endif
                            </div>
                        </x-menu>
                    </x-slot:sidebar>
                @endpersist
            @endauth
            <x-slot:content class="mt-14">
                @auth
                    @persist('navbar')
                        <livewire:navbar></livewire:navbar>
                    @endpersist
                @endauth
                {{ $slot }}
            </x-slot:content>
        </x-main>
</body>

</html>
