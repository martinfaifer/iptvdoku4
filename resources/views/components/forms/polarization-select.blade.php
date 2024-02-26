@php
    $polarization = [
        [
            'id' => 'vertikální',
            'name' => 'vertikální',
        ],
        [
            'id' => 'horizontální',
            'name' => 'horizontální',
        ],
    ];
@endphp
<x-choices label="Polarizace" :options="$polarization" single />
