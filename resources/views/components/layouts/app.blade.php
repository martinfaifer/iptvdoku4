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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/a6yh9ynf4jozp4fh5ifm4ge2jyxhqtpzbisgvawi52igqueb/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-r bg-[#0A0F19] min-h-screen">

    @persist('toast')
        <x-toast />
    @endpersist

    @auth
        <x-spotlight search-text="Vyhledejte ... " no-results-text="Ops! Nenalezeno." class="justify-center bg-[#132231]"
            shortcut="alt.space" />
        @persist('navbar')
            <livewire:navbar></livewire:navbar>
        @endpersist
    @endauth

    <x-main full-width>

        @auth
            <x-slot:sidebar class="bg-[#111827] border-r border-[#1f2937] !w-[320px]">
                <x-menu activate-by-route active-bg-color="bg-sky-950" class="-ml-4 -mt-2">
                    <ul class="menu bg-[#0A0F19] h-full fixed ml-2">
                        <li href="/channels" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#1A1E2A]' => request()->is('channels') || request()->is('channels/*'),
                        ])>
                            <a>
                                <x-sui-tv-mode class="h-6 w-6" fill="none" />
                            </a>
                        </li>
                        <li href="/devices" wire:navigate @class([
                            'rounded-lg',
                            'bg-[#1A1E2A]' => request()->is('devices') || request()->is('devices/*'),
                        ])>
                            <a>
                                <x-sui-flip-view class="h-6 w-6" fill="none" />
                            </a>
                        </li>
                    </ul>
                </x-menu>
                {{-- main dynamic navigation --}}
                <x-menu activate-by-route active-bg-color="bg-sky-950" class="ml-16 !h-full">
                    <div class="overflow-y-auto">
                        @if (request()->is('/') || request()->is('channels') || request()->is('channels/*'))
                            <livewire:iptv.channels.menu.channels-menu />
                        @endif
                        @if (request()->is('devices') || request()->is('devices/*'))
                            <livewire:iptv.devices.menu.devices-menu class="fixed" />
                        @endif
                    </div>
                </x-menu>
                </div>
            </x-slot:sidebar>
        @endauth
        <x-slot:content class="mt-14">
            {{ $slot }}
        </x-slot:content>
    </x-main>
</body>

</html>
