<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.svg') }}">
    <link rel="manifest" href="/site.webmanifest">
    <title>{{ $title ?? 'IPTVdokumentace4' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.1/styles/github.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/diff2html/bundles/css/diff2html.min.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/diff2html/bundles/js/diff2html-ui.min.js"></script>
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#000100] min-h-screen">
    <x-toast />
    @auth
        <x-spotlight search-text="Vyhledejte ... " no-results-text="Ops! Nenalezeno."
            class="justify-center bg-gradient-to-b from-[#111827]/50 to-transparent" shortcut="ctrl.space" />
        {{-- show alerts --}}
        <livewire:alert-component>
        @endauth

        <x-main full-width>
            @auth
                <x-slot:sidebar
                    class="bg-gradient-to-b from-slate-950/80 to-black/40 border-r border-[#64748b] border-opacity-10 !w-[320px]">
                    <x-menu activate-by-route active-bg-color="bg-sky-950" class="-ml-4 -mt-2 ">
                        <ul class="menu bg-[#020411]/20 border-r border-[#64748b] border-opacity-10 h-full ml-2 fixed">
                            <li href="/channels" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' => request()->is('channels') || request()->is('channels/*'),
                            ])>
                                <a>
                                    <x-sui-tv-mode class="size-6 text-white" fill="none" />
                                </a>
                            </li>
                            <li href="/devices" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' => request()->is('devices') || request()->is('devices/*'),
                            ])>
                                <a>
                                    <x-sui-flip-view class="size-6 text-white" fill="none" />
                                </a>
                            </li>
                            <li href="/sat-cards" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' =>
                                    request()->is('sat-cards') || request()->is('sat-cards/*'),
                            ])>
                                <a>
                                    <x-heroicon-o-credit-card class="size-6 text-white/80" fill="none" />
                                </a>
                            </li>
                            <li href="/calendar" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' => request()->is('calendar') || request()->is('calendar/*'),
                            ])>
                                <a>
                                    <x-heroicon-o-calendar-days class="size-6 text-white/80" fill="none" />
                                </a>
                            </li>
                            <li href="/sftps" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' => request()->is('sftps') || request()->is('sftps/*'),
                            ])>
                                <a>
                                    <x-heroicon-o-arrow-up-on-square-stack class="size-6 text-white/80" fill="none" />
                                </a>
                            </li>
                            <li href="/wiki" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' => request()->is('wiki') || request()->is('wiki/*'),
                            ])>
                                <a>
                                    <x-heroicon-o-academic-cap class="size-6 text-white/80" fill="none" />
                                </a>
                            </li>
                        </ul>
                    </x-menu>
                    {{-- main dynamic navigation --}}
                    <x-menu activate-by-route active-bg-color="bg-sky-950" class="ml-16 fixed !h-full">
                        <div class="overflow-y-scroll hover:overflow-scroll">
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
                            @if (request()->is('settings') || request()->is('settings/*'))
                                <livewire:settings.settings-navigation-component class="fixed" />
                            @endif
                        </div>
                    </x-menu>
                </x-slot:sidebar>


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