<div>
    <x-share.cards.base-card title="Celkové využití offerů">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                {{-- <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus /> --}}
            </div>
            <div class="col-span-6 md:col-span-3">
                <x-button wire:click='exportToCsv()'
                    class="btn btn-sm btn-doku-primary mt-2 sm:absolute right-5 sm:right-10">
                    Export do csv
                </x-button>
            </div>
        </div>
        <div class="h-96 overflow-y-auto mt-12">
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offersUsage as $key => $offerUsage)
                            <tr>
                                <th>{{ $key }}</th>
                                @foreach ($offersUsage[$key] as $offerName => $usage)
                                    <td>{{ $offerName }}</td>
                                    <td>{{ $usage }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-share.cards.base-card>
</div>
