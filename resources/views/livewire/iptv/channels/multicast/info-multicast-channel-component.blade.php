<div>
    <x-share.cards.base-card title="Informace o multicastu">
        {{-- list of multicast datas --}}
        @foreach ($multicasts as $multicast)
            <div wire:key='multicast-{{ $multicast->id }}' class="grid grid-cols-12 gap-4 font-semibold dark:text-[#A3ABB8]">
                <div class="col-span-12 xl:col-span-3 flex">
                    <p>
                        <span class="font-normal">
                            Zdrojová IP:
                        </span>
                        <span @class([
                            'ml-3',
                            'text-green-500' => $this->isInIptvDohledDohled($multicast->source_ip),
                        ])>
                            {{ $multicast->source_ip }}
                        </span>
                    </p>
                    <x-share.btns.copy-btn dataToCopy="{{ $multicast->source_ip }}" />
                </div>
                <div class="col-span-12 xl:col-span-3 mt-4 xl:mt-0">
                    <p>
                        <span class="font-normal">
                            Zdroj:
                        </span>
                        <span class="ml-3">
                            {{ $multicast->channel_source->name }}
                        </span>
                    </p>
                </div>
                <div class="xl:col-span-3 col-span-12 mt-4 xl:mt-0 flex">
                    <p>
                        <span class="font-normal">
                            STB IP:
                        </span>
                        <span @class([
                            'ml-3',
                            'text-green-500' => $this->isInIptvDohledDohled($multicast->stb_ip),
                        ])">
                            {{ $multicast->stb_ip }}
                        </span>
                    </p>
                    <x-share.btns.copy-btn dataToCopy="{{ $multicast->stb_ip }}" />
                </div>
                <div class="col-span-12 xl:col-span-2 mt-4 xl:mt-0">
                    <p>
                        <span class="font-normal">
                            Typ:
                        </span>
                        <span class="ml-3">
                            @if ($multicast->is_backup)
                                <span class="text-orange-500">
                                    Záloha
                                </span>
                            @else
                                <span class="text-green-500">
                                    Primár
                                </span>
                            @endif
                        </span>
                    </p>
                </div>
                <div class="col-span-12 xl:col-span-1 mt-4 xl:-mt-2">
                    @can('operate_with_childs', App\Models\Channel::class)
                        @if ($this->isInIptvDohledDohled($multicast->stb_ip))
                            <div class="tooltip tooltip-bottom" data-tip="Upozornění na výpadky">
                                <button class="btn btn-sm btn-circle bg-transparent border-none shadow-none"
                                    href="/channels/{{ $channel->id }}/notifications?stream_url={{ $multicast->stb_ip }}"
                                    wire:navigate>
                                    <x-heroicon-o-bell @class([
                                        'w-4 h-4',
                                        'text-green-500' => $this->can_notify($multicast->stb_ip),
                                        'text-slate-500' => !$this->can_notify($multicast->stb_ip),
                                    ]) />
                                </button>
                            </div>
                        @endif
                        <button class="btn btn-sm btn-circle bg-transparent border-none shadow-none"
                            wire:click='edit({{ $multicast->id }})'>
                            <x-heroicon-m-pencil class="w-4 h-4 text-green-500" />
                        </button>
                    @endcan
                    @can('operate_with_childs', App\Models\Channel::class)
                        <button class="btn btn-sm btn-circle bg-transparent border-none shadow-none"
                            wire:click='destroy({{ $multicast->id }})' wire:confirm="Opravdu odebrat?">
                            <x-heroicon-m-trash class="w-4 h-4 text-red-500" />
                        </button>
                    @endcan
                </div>
            </div>
            <x-share.lines.small-hr></x-share.lines.small-hr>
        @endforeach
    </x-share.cards.base-card>
    {{-- edit dialog --}}
    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeModal'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                {{-- name --}}
                <div class="col-span-12 mb-4">
                    <x-input label="IP k STB" wire:model="form.stb_ip" />
                    <div>
                        @error('stb_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="Zdrojová IP" wire:model="form.source_ip" />
                    <div>
                        @error('source_ip')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-choices-offline searchable label="Zdroj" wire:model="form.channel_source_id" :options="$channelSources"
                        single />
                    <div>
                        @error('channel_source_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- is_backup --}}
                <div class="col-span-6 mb-4">
                    <x-toggle label="Záloha" wire:model="form.is_backup" />
                    <div>
                        @error('is_backup')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if ($form->isInDohled)
                    <div class="col-span-6 mb-4">
                        <x-toggle label="Odebrat z dohledu" wire:model="form.delete_from_dohled" />
                        <div>
                            @error('delete_from_dohled')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif
                @if (!$form->isInDohled)
                    <div class="col-span-6 mb-4">
                        <x-toggle label="Přidat do dohledu" wire:model="form.to_dohled" />
                        <div>
                            @error('to_dohled')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        wire:click='closeModal' />
                </div>
                <div>
                    <x-button label="Změnit" class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
