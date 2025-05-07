<div>
    <ul class="menu w-60" wire:scroll>
        @foreach ($ispsWithIpPrefixes as $nanguIsp)
            <li wire:key='nangu_isp_{{ $nanguIsp->id }}'>
                <details open>
                    <summary class="font-semibold">
                        {{ $nanguIsp->name }}
                    </summary>
                    <ul>
                        @foreach ($nanguIsp->ipprefixes as $ipprefix)
                            <li id="prefixes_{{ $ipprefix->id }}" wire:key='prefixes_{{ $ipprefix->id }}'
                                @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-slate-800/5 dark:bg-sky-950' =>
                                        request()->is('prefixes/' . $ipprefix->id) ||
                                        request()->is('prefixes/' . $ipprefix->id . '/*'),
                                ]) href="/prefixes/{{ $ipprefix->id }}" wire:navigate><a>

                                    <div class="grid grid-cols-12 gap-1">
                                        <div class="col-span-12">
                                            {{ $ipprefix->ip_address }}/{{ $ipprefix->cidr }}
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

            document.addEventListener('livewire:navigating', () => {
                //
            });

            document.addEventListener('livewire:navigated', () => {
                let element = document.getElementById('device_' + parsedUrl.slice(-1));
                // element.classList.add('bg-sky-950');
                element.scrollIntoView({

                });
            });
        </script>
    @endscript
</div>
