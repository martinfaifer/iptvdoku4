@php
    $headers = [
        ['key' => 'message', 'label' => 'Problém', 'class' => 'text-white/80'],
        ['key' => 'created_at', 'label' => 'Vytvořeno', 'class' => 'text-white/80'],
    ];
@endphp
<div>
    <x-share.cards.base-card title="Problémy na zařízení">
        @if (!$deviceAlerts->isEmpty())
            <div class="h-32 overflow-y-auto">
                <x-table :headers="$headers" :rows="$deviceAlerts">
                    @scope('cell_message', $deviceAlert)
                        <span class="text-red-500 font-semibold">
                            {{ $deviceAlert->message }}
                        </span>
                    @endscope
                </x-table>
            </div>
            @else
            <x-share.alerts.info title="Nenalezeny žádné problémy"></x-share.alerts.info>
        @endif
    </x-share.cards.base-card>
</div>
