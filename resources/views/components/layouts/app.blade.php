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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- [#1E293B] --}}

<body class="bg-[#06090e] min-h-screen">

    <x-toast />

    @auth
        <x-spotlight search-text="Vyhledejte ... " no-results-text="Ops! Nenalezeno."
            class="justify-center bg-gradient-to-b from-[#111827]/50 to-transparent" shortcut="ctrl.space" />

        {{-- show alerts --}}
        <livewire:alert-component>
        @endauth

        <x-main full-width>
            @auth
                <x-slot:sidebar class="bg-[#0A0F19]/80 border-r border-[#141b25] !w-[320px]">
                    <x-menu activate-by-route active-bg-color="bg-sky-950" class="-ml-4 -mt-2 ">
                        <ul class="menu bg-[#0A0F19]/80 border-r border-[#0e151f] h-full fixed ml-2">
                            <li href="/channels" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' => request()->is('channels') || request()->is('channels/*'),
                            ])>
                                <a>
                                    <x-sui-tv-mode class="h-6 w-6 text-white" fill="none" />
                                </a>
                            </li>
                            <li href="/devices" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' => request()->is('devices') || request()->is('devices/*'),
                            ])>
                                <a>
                                    <x-sui-flip-view class="h-6 w-6 text-white" fill="none" />
                                </a>
                            </li>
                            <li href="/sat-cards" wire:navigate @class([
                                'rounded-lg',
                                'bg-[#1A1E2A]' =>
                                    request()->is('sat-cards') || request()->is('sat-cards/*'),
                            ])>
                                <a>
                                    <x-heroicon-o-credit-card class="h-6 w-6 text-white/80" fill="none" />
                                </a>
                            </li>
                        </ul>
                    </x-menu>
                    {{-- main dynamic navigation --}}
                    <x-menu activate-by-route active-bg-color="bg-sky-950" class="ml-16 !h-full ">
                        <div class="overflow-y-auto">
                            @if (request()->is('/') || request()->is('channels') || request()->is('channels/*'))
                                <livewire:iptv.channels.menu.channels-menu />
                            @endif
                            @if (request()->is('devices') || request()->is('devices/*'))
                                <livewire:iptv.devices.menu.devices-menu class="fixed" />
                            @endif
                            @if (request()->is('sat-cards') || request()->is('sat-cards/*'))
                                <livewire:iptv.cards.menu.satelit-cards-menu class="fixed" />
                            @endif
                            @if (request()->is('settings') || request()->is('settings/*'))
                                <livewire:settings.settings-navigation-component class="fixed" />
                            @endif
                        </div>
                    </x-menu>
                    </div>
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
