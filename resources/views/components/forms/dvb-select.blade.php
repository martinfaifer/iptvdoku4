@php
    $dvbs = [
        [
            'id' => 'DVB-S',
            'name' => 'DVB-S',
        ],
        [
            'id' => 'DVB-S2',
            'name' => 'DVB-S2',
        ],
        [
            'id' => 'DVB-T',
            'name' => 'DVB-T',
        ],
        [
            'id' => 'DVB-T2',
            'name' => 'DVB-T2',
        ],
    ];
@endphp
<x-choices label="DVB" :options="$dvbs" single />
