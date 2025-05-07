<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="dark:!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-button class="btn btn-sm btn-doku-primary mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nový poplatek za offer
                </x-button>
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$offerTaxes" with-pagination>
                @scope('cell_channels_id', $channelPackagesTax)
                    @foreach (json_decode($channelPackagesTax->channels_id) as $channel_id)
                        @php
                            $channel = null;

                            $channel = App\Models\Channel::find($channel_id);
                        @endphp
                        @if (!is_null($channel))
                            {{ $channel->name }} ,
                        @endif
                    @endforeach
                @endscope
                @scope('cell_actions', $offerTax)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="edit({{ $offerTax->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent shadow-none"
                            wire:click="destroy({{ $offerTax->id }})" wire:confirm="Opravdu odebrat poplatek?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model="createModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input label="Offer" wire:model="form.offer" />
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Kanály" wire:model="form.channels_id" :options="$channels" searchable />
                </div>
                <div class="col-span-12">
                    <x-input type="number" step="0.001" label="cena" wire:model="form.price" />
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Měna" wire:model="form.currency" :options="$currencies" searchable single />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input disabled readonly label="Offer" wire:model="updateForm.offer" />
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Kanály" wire:model="updateForm.channels_id" :options="$channels"
                        searchable />
                </div>
                <div class="col-span-12">
                    <x-input type="number" step="0.001" label="cena" wire:model="updateForm.price" />
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Měna" wire:model="updateForm.currency" :options="$currencies" searchable
                        single />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
