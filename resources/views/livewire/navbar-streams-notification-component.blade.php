<div>
    {{-- @dd($othersAlerts) --}}
    <label @click='$wire.openAlertDrawer' class="btn btn-sm btn-circle bg-transparent border-none shadow-none">
        <x-heroicon-c-bell @class([
            'h-6 w-6',
            'text-red-500' =>
                !empty($iptv_dohled_alerts) || !empty($othersAlerts['devices']),
            'text-gray-500' =>
                empty($iptv_dohled_alerts) && empty($othersAlerts['devices']),
        ]) />
        @if (!empty($iptv_dohled_alerts) || !empty($othersAlerts['devices']))
            <div class="text-white text-sm bg-red-500 rounded-full fixed w-5 h-5 ml-4 mt-3">
                {{ count($iptv_dohled_alerts) + count($othersAlerts['devices']) }}
            </div>
        @endif
    </label>

    <x-drawer wire:model="alertDrawer" id="alert-drawer" right class="lg:w-1/4 dark:!bg-[#0E1E33]">

        {{-- alerts --}}
        @if (!empty($iptv_dohled_alerts))
            {{-- <audio src="/storage/sounds/beep-warning.mp3" autoplay></audio> --}}
            @foreach ($iptv_dohled_alerts as $iptv_dohled_alert)
                <div wire:key="alert-{{ $iptv_dohled_alert['id'] }}" class="mt-3">
                    <x-share.alerts.error title="{{ $iptv_dohled_alert['nazev'] }}"></x-share.alerts.error>
                </div>
            @endforeach
        @endif

        @if (!empty($othersAlerts['devices']))
            @foreach ($othersAlerts['devices'] as $device)
                {{-- @dd($device) --}}
                <div wire:key="alert-device-{{ $device->id }}" class="mt-3">
                    <x-share.alerts.error title="Zařízení {{ $device->name }} je offline"></x-share.alerts.error>
                </div>
            @endforeach
        @endif
    </x-drawer>

    @if (count($iptv_dohled_alerts) >= 6)
        <div class="invisible md:visible toast toast-top toast-center mt-2 z-50">
            <div class="alert alert-error font-semibold text-white/80">
                <span class="hover:underline">
                    <a href="{{ config('services.api.iptvDohled.url') }}" target="_blank">
                        Nefunguje velké množství streamů!
                    </a>
                </span>
            </div>
        </div>
    @endif
</div>

