<div>
    <div class="flex flex-col">
        <div class="relative">
            <div class="absolute left">
                <livewire:iptv.cards.create-satelit-card>
            </div>
        </div>
        {{-- show alert about no sat card found --}}
        @if (is_null($satelitCard) || is_null($satelitCard->name))
            <div class="mt-12">
                <x-share.alerts.info title="Vyberte satelitní kartu z menu vlevo"></x-share.alerts.info>
            </div>
        @else
            {{-- tags --}}
            <div>
                <livewire:tag-component type="satelit_card" itemId="{{ $satelitCard->id }}"></livewire:tag-component>
            </div>
            <div class="grid grid-cols-12 mt-8">
                <div class="col-span-12 flex">
                    <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                        {{ $satelitCard->name }}
                    </h1>

                    @if ($satelitCard->status == 1)
                        <div class="bg-[#1EB15B] text-white text-xs my-auto ml-6 mt-9 rounded-md">
                            <span class="mx-3">
                                použito
                            </span>
                        </div>
                    @endif
                    @if ($satelitCard->status == 0)
                        <div class="bg-red-700 text-white text-xs my-auto ml-6 mt-9 rounded-md">
                            <span class="mx-3">
                                nepoužívá se
                            </span>
                        </div>
                    @endif

                    {{-- actions --}}
                    <livewire:iptv.cards.update-satelit-card-component
                        :satelitCard="$satelitCard"></livewire:iptv.cards.update-satelit-card-component>

                    <livewire:iptv.cards.delete-satelit-card-component
                        :satelitCard="$satelitCard"></livewire:iptv.cards.delete-satelit-card-component>
                    {{-- end of actions --}}
                </div>
            </div>
            <hr
                class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
            <div class="mt-4">
                <div class="grid grid-cols-12 gap-4">
                    {{-- information about card --}}
                    <div class="col-span-12 md:col-span-12 xl:col-span-6">
                        <x-share.cards.base-card title="Informace o kartě">
                            <div class="grid grid-cols-12 gap-4 font-semibold text-[#A3ABB8]">
                                <div class="col-span-12 md:col-span-4 ">
                                    <p>
                                        <span class="font-normal">
                                            Distributor:
                                        </span>
                                        <span class="ml-3">
                                            {{ $satelitCard->vendor->name }}
                                        </span>
                                    </p>
                                </div>
                                @if ($device != false)
                                    <div class="col-span-12 md:col-span-4">
                                        <div>
                                            <p>
                                                <span class="font-normal">
                                                    Zařízení:
                                                </span>
                                                <span class="ml-3">
                                                    {{ $device->name }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </x-share.cards.base-card>
                    </div>
                    {{-- expirations --}}
                    <div class="col-span-12 md:col-span-12 xl:col-span-6">
                        <livewire:iptv.cards.expiration-component
                            :satelitCard="$satelitCard"></livewire:iptv.cards.expiration-component>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4 mt-4">
                    {{-- logs --}}
                    <div class="col-span-12 md:col-span-12 xl:col-span-4 mb-4">
                        <livewire:log-component columnValue="satelit_card:{{ $satelitCard->id }}" column="item" />
                    </div>
                    {{-- contacts --}}
                    <div class="col-span-12 md:col-span-12 xl:col-span-4">
                        <livewire:contact-component type="satelit_card" :item_id="$satelitCard->id" />
                    </div>
                    {{-- poznámky --}}
                    <div class="col-span-12 md:col-span-12 xl:col-span-4">
                        <livewire:notes.note-component column="satelit_card_id" :id="$satelitCard->id" />
                    </div>
                    <div class="col-span-12 mb-4">
                        <livewire:iptv.cards.satelit-card-contents-component :satCard="$satelitCard"/>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
