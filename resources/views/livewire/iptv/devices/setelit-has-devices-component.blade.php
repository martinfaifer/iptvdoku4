<div>
    <x-share.cards.base-card title="Vazba na zařízení">
        <div class="h-32 overflow-y-auto">
            @if ($hasDevices->isEmpty())
            <x-share.alerts.info title="Nenalezena žádná vazba"></x-share.alerts.info>
            @else
                <x-table :headers="$headers" :rows="$hasDevices">
                    @scope('cell_name', $device)
                        <a class="hover:underline text-blue-500 hover:text-blue-700" href="/devices/{{ $device->id }}"
                            target="_blank">{{ $device->name }}</a>
                    @endscope
                </x-table>
            @endif
        </div>
    </x-share.cards.base-card>
</div>
