@php
    $satelits = App\Models\Device::where('device_category_id', App\Models\DeviceCategory::where('name', 'Satelity')->first()->id)->get();
@endphp
<x-choices label="Satelity" :options="$satelits" single />
