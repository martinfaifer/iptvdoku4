<div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 ">
            @foreach ($programmersUsage as $programmer => $channelsUsage)
                <div class="mt-12">
                    <x-share.cards.base-card title="{{ $programmer }}">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6 md:col-span-9 ">
                                {{-- <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass"
                                    autofocus /> --}}
                            </div>
                            <div class="col-span-6 md:col-span-3">
                                <x-button wire:click="exportToCsv('{{ $programmer }}')"
                                    class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm mt-2 sm:absolute right-5 sm:right-10">
                                    Export do csv
                                    <div wire:loading wire:target="exportToCsv('{{ $programmer }}')">
                                        <span class="loading loading-spinner loading-md"></span>
                                    </div>
                                </x-button>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <div class="h-96 overflow-y-auto mt-12">
                                <div class="overflow-x-auto">
                                    <table class="table table-xs">
                                        <!-- head -->
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($channelsUsage as $channel => $usagePerIsp)
                                                <tr>
                                                    <th>{{ $channel }}</th>
                                                    @foreach ($usagePerIsp as $isp => $usage)
                                                        <td>{{ $isp }}</td>
                                                        <td>{{ $usage }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </x-share.cards.base-card>
                </div>
            @endforeach
        </div>
    </div>
</div>
