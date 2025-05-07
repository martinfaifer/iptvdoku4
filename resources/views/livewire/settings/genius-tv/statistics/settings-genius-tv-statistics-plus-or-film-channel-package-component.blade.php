<div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <x-share.cards.base-card title="Využití balíčků PLUS / FILM">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6 md:col-span-9 ">
                        {{-- <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                            class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass"
                            autofocus /> --}}
                    </div>
                    <div class="col-span-6 md:col-span-3">
                        <x-button wire:click="exportUsage"
                            class="btn btn-sm btn-doku-primary mt-2 sm:absolute right-5 sm:right-10">
                            Export
                            <div wire:loading wire:target="exportUsage">
                                <span class="loading loading-spinner loading-md"></span>
                            </div>
                        </x-button>
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="max-h-96 overflow-y-auto mt-12">
                        <div class="overflow-x-auto">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usage as $isp => $use)
                                        <tr>
                                            <th>{{ $use['isp'] }}</th>
                                            <td class="font-semibold">{{ $use['usage'] }}</td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </x-share.cards.base-card>
        </div>
    </div>
</div>
