<div>
    <ul class="menu w-60" wire:poll.5min>
        @foreach ($categoriesWithDevices as $category)
            <li wire:key=='category_{{ $category->id }}'>
                <details open>
                    <summary class="font-semibold">
                        {{-- <x-icon name="gmdi.ip" /> --}}
                        {{-- <x-gmdi-ip class="w-6 h-6 text-gray-500"/> --}}

                        {{ $category->name }}
                    </summary>
                    <ul>
                        @foreach ($category->devices as $device)
                            <li id="device_{{ $device->id }}" wire:key='device_{{ $device->id }}'
                                @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' =>
                                        request()->is('devices/' . $device->id) ||
                                        request()->is('devices/' . $device->id . '/*'),
                                ]) href="/devices/{{ $device->id }}" wire:navigate><a>
                                    @if (isset($device->nms_status) && $device->nms_status == 1)
                                        <div class="bg-green-500 w-1 h-1 rounded-full">
                                        </div>
                                    @endif
                                    @if (isset($device->nms_status) && $device->nms_status == 3)
                                    <div class="bg-red-500 w-1 h-1 rounded-full">
                                    </div>
                                    @endif
                                    {{ $device->name }}
                                </a></li>
                        @endforeach
                    </ul>
                </details>
            </li>
        @endforeach
    </ul>
    @script
        <script>
            let url = window.location.href;
            let parsedUrl = url.split("/");

            document
                .getElementById('device_' + parsedUrl.slice(-1))
                .scrollIntoView({});
        </script>
    @endscript
</div>
