<div>
    {{-- @can('view_devices', App\Models\Device::class) --}}
    <ul class="menu w-60" wire:scroll>
        @foreach ($categoriesWithDevices as $category)
            <li wire:key='category_{{ $category->id }}'>
                <details open>
                    <summary class="font-semibold">
                        @if (!is_null($category->icon))
                            <img class="object-cover w-4 h-4"
                                src="/storage/{{ str_replace('public/', '', $category->icon) }}" alt="" />
                        @endif
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

                                    <div class="grid grid-cols-12 gap-1">
                                        <div class="col-span-1 mt-2">
                                            @if (isset($device->nms_status) && $device->nms_status == 1)
                                                <div class="bg-green-500 w-1 h-1 rounded-full">
                                                </div>
                                            @endif
                                            @if (isset($device->nms_status) && $device->nms_status == 3)
                                                <div class="bg-red-500 w-1 h-1 rounded-full">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-span-2">
                                            @if (!is_null($category->icon))
                                                <img class="object-cover w-4 h-4"
                                                    src="/storage/{{ str_replace('public/', '', $category->icon) }}"
                                                    alt="" />
                                            @endif
                                        </div>
                                        <div class="col-span-9">
                                            {{ $device->name }}
                                        </div>
                                    </div>

                                </a>
                            </li>
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

            if (parsedUrl =! null) {
                document.addEventListener('livewire:navigated', () => {
                    let element = document.getElementById('device_' + parsedUrl.slice(-1));
                    // element.classList.add('bg-sky-950');
                    element.scrollIntoView({

                    });
                });
            }
        </script>
    @endscript
    {{-- @endcan --}}
</div>
