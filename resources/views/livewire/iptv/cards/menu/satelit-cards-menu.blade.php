<div>
    <ul class="menu w-60">
        @foreach ($satelitCardsWithVendor as $vendor)
            <li wire:key=='vendor_{{ $vendor->id }}'>
                <details open>
                    <summary class="font-semibold">
                        {{ $vendor->name }}
                    </summary>
                    <ul>
                        @foreach ($vendor->satelit_cards as $satCard)
                            <li id="satcard_{{ $satCard->id }}" wire:key='satcard_{{ $satCard->id }}'
                                @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-slate-800/5 dark:bg-sky-950' =>
                                        request()->is('sat-cards/' . $satCard->id) ||
                                        request()->is('sat-cards/' . $satCard->id . '/*'),
                                ]) href="/sat-cards/{{ $satCard->id }}" wire:navigate><a>

                                    <div class="grid grid-cols-12 gap-1">
                                        <div class="col-span-1 mt-2">
                                            @if ($satCard->status == true)
                                                <div class="bg-green-500 w-1 h-1 rounded-full">
                                                </div>
                                            @endif
                                            @if ($satCard->status == false)
                                                <div class="bg-red-500 w-1 h-1 rounded-full">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-span-2">

                                        </div>
                                        <div class="col-span-9">
                                            {{ $satCard->name }}
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

            try {
                document
                    .getElementById('satcard_' + parsedUrl.slice(-1))
                    .scrollIntoView({});
            } catch (error) {

            }
        </script>
    @endscript
</div>
