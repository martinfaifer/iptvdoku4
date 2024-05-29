<div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                Mapa zapojení
            </h1>
        </div>
        <div class="col-span-12">
            <p class="text-xl font-semibold">
                Počet zařízeních {{ count($devices) }}
            </p>
        </div>
        <div class="col-span-12">
            <x-share.cards.base-card title="">
                <div class="h-[42rem] overflow-auto">
                    <div class="grid grid-cols-12 gap-4">
                        @foreach ($devices as $device)
                        <div class="col-span-1">
                            <div class="bg-[#092A43] rounded-xl">
                                <div class="px-4 py-4 text-xs justify-center">
                                     {{ $device->name }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </x-share.cards.base-card>
        </div>
    </div>
</div>
