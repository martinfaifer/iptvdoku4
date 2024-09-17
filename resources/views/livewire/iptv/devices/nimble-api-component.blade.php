@php
    $outgoingheaders = [
        [
            'key' => 'stream',
            'label' => 'Stream',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'paused',
            'label' => 'Pozastaveno / Akce',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'status',
            'label' => 'Status',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'video_source',
            'label' => 'Zdroj',
            'class' => 'text-[#A3ABB8]',
        ],
    ];

    $incomingheaders = [
        [
            'key' => 'protocol',
            'label' => 'Stream',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'status',
            'label' => 'Status',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'description',
            'label' => 'Description',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'bandwidth',
            'label' => 'Bandwidth',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'actions',
            'label' => '',
        ],
    ];
@endphp
<div>
    <x-share.cards.base-card title="Nimble API">
        <div>
            <button
                class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-blue-500 tooltip tooltip-left"
                data-tip="Editace skrz API" @click='$wire.openEditServerApiModal()'>
                <x-heroicon-o-cursor-arrow-ripple class="w-4 h-4" />
            </button>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-4">
            <div class="col-span-12 overflow-y-scroll max-h-36">
                <p class="text-center">Výstupní streamy</p>
                <x-table :headers="$outgoingheaders" :rows="$outcomingStreams">
                    @scope('cell_paused', $outcomingStream)
                        @if ($outcomingStream['paused'] != 'false')
                            <div class="flex">
                                <x-heroicon-o-check class="h-4 w-4 text-green-500" />
                                {{-- <button class="ml-4 -mt-1 bg-transparent btn-xs tooltip tooltip-right"
                                    data-tip="Spustit stream">
                                    <x-heroicon-o-play-circle class="inline h-4 w-4 text-green-300" />
                                </button> --}}
                            </div>
                        @else
                            <div class="flex">
                                <x-heroicon-o-x-mark class="h-4 w-4 text-red-500" />
                                {{-- <button class="ml-4 -mt-1 bg-transparent btn-xs tooltip tooltip-right"
                                    data-tip="Zastavit stream">
                                    <x-heroicon-o-pause-circle class="inline h-4 w-4 text-red-300 " />
                                </button>
                                <button class="ml-4 -mt-1 bg-transparent btn-xs tooltip tooltip-right" data-tip="Restart">
                                    <x-heroicon-o-arrow-path class="inline h-4 w-4 text-blue-300 "/>
                                </button> --}}
                            </div>
                        @endif
                    @endscope

                    @scope('cell_status', $outcomingStream)
                        @if ($outcomingStream['status'] == 'synced')
                            <div
                                class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-green-800 text-neutral-200 rounded-sm w-14 h-4">
                                Sync
                            </div>
                        @else
                            <div
                                class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-red-800 text-neutral-200 rounded-sm w-20 h-4">
                                Problem
                            </div>
                        @endif
                    @endscope
                    @scope('cell_video_source', $outcomingStream, $incomingStreams)
                        @php
                            $incoming = '';
                            foreach ($incomingStreams as $incomingStream) {
                                if ($incomingStream['id'] == $outcomingStream['video_source']['id']) {
                                    $source = $incomingStream;
                                    break;
                                }
                            }
                        @endphp
                        <div class="flex">
                            @if (array_key_exists('description', $source))
                                {{ $source['description'] }}
                                <button wire:click='openSourceDetailStream({{ json_encode($source) }})'
                                    class="btn btn-sm btn-circle border-none bg-transparent ml-4 -mt-1">
                                    <x-heroicon-o-magnifying-glass class="w-4 h-4 text-blue-500" />
                                </button>
                            @endif
                        </div>
                    @endscope
                </x-table>
            </div>
        </div>
    </x-share.cards.base-card>


    <x-modal wire:model.live="editServerApiModal" title="Vzdálená správa serveru" persistent>
        <div class="my-4">
            {{-- @if (array_key_exists('status', $nimbleServerApiData) && $nimbleServerApiData['status'] == 'Ok')
                <x-form wire:submit="updateNimbleServerName">
                    <div class="grid grid-cols-12 gap-4 ">
                        <div class="col-span-12 md:col-span-10">
                            <x-input label="Název serveru v Nimble WMS" wire:model.live="nimbleServerApiData.server.name" />
                        </div>
                        <div class="col-span-12 md:col-span-2">
                            <x-button label="Upravit"
                                class="bg-sky-800 hover:bg-sky-700 text-white font-semibold md:mt-7 w-full md:w-auto" type="submit"
                                spinner="updateNimbleServerName" />
                        </div>
                    </div>
                </x-form>
            @endif --}}
            <div class="grid grid-cols-12 gap-4 mt-4">
                <div class="col-span-12 overflow-y-scroll max-h-96">
                    <x-table :headers="$incomingheaders" :rows="$incomingStreams">

                        @scope('cell_protocol', $incomingStream)
                            @if (array_key_exists('protocol', $incomingStream))
                                {{ $incomingStream['protocol'] }}
                            @endif
                            @if (array_key_exists('ip', $incomingStream))
                                {{ $incomingStream['ip'] }}
                            @endif
                            @if (array_key_exists('port', $incomingStream))
                                {{ $incomingStream['port'] }}
                            @endif
                        @endscope
                        @scope('cell_status', $incomingStream)
                            @if ($incomingStream['status'] == 'online')
                                <span class="text-green-500 font-semibold">
                                    {{ $incomingStream['status'] }}
                                </span>
                            @else
                                <span class="text-red-500 font-semibold">
                                    {{ $incomingStream['status'] }}
                                </span>
                            @endif
                        @endscope
                        @scope('cell_actions', $incomingStream)
                            @php
                                $streamId = json_encode($incomingStream['id']);
                            @endphp
                            @if ($incomingStream['status'] != 'online')
                                <button wire:click='startIncomingStream({{ $streamId }})'
                                    wire:confirm='Opravdu si přejete spustit?' class="ml-4 bg-transparent btn-xs tooltip "
                                    data-tip="Spustit vstupní stream">
                                    <x-heroicon-o-play-circle class="inline h-4 w-4 text-green-500" />
                                </button>
                            @else
                                <button wire:click='stopIncomingStream({{ $streamId }})'
                                    wire:confirm='Opravdu si přejete pozastavit?'
                                    class="ml-4 -mt-1 bg-transparent btn-xs tooltip" data-tip="Zastavit vstupní stream">
                                    <x-heroicon-o-pause-circle class="inline h-4 w-4 text-red-500 " />
                                </button>
                                <button wire:click="restartStream({{ $streamId }})"
                                    class="ml-4 -mt-1 bg-transparent btn-xs tooltip " data-tip="Restart vstupu"
                                    wire:confirm='Opravdu si přejete restartovat?'>
                                    <x-heroicon-o-arrow-path class="inline h-4 w-4 text-blue-500 " />
                                </button>
                            @endif
                        @endscope
                    </x-table>
                </div>
            </div>
        </div>
        <div class="flex justify-between">
            <div>
            </div>
            <div>
                <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4 border-none"
                    wire:click='closeModal' />
            </div>
        </div>
    </x-modal>

    <x-modal wire:model.live="detailModal" title="Informace o vstupním streamu">
        <div class="my-4">
            @if (!empty($sourceStream))
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        <span class="font-semibold">
                            Status:
                        </span>
                        <span @class([
                            'ml-4 font-semibold',
                            'text-green-500' => $sourceStream['status'] == 'online',
                            'text-red-500' => $sourceStream['status'] != 'online',
                        ])>
                            {{ $sourceStream['status'] }}
                        </span>
                    </div>
                    <div class="col-span-6">
                        <span class="font-semibold">
                            protocol:
                        </span>
                        <span class="ml-4">
                            {{ $sourceStream['protocol'] }}
                        </span>
                    </div>
                    <div class="col-span-6">
                        <span class="font-semibold">
                            ip:
                        </span>
                        <span class="ml-4">
                            @if (array_key_exists('ip', $sourceStream) && array_key_exists('port', $sourceStream))
                                {{ $sourceStream['ip'] }}:{{ $sourceStream['port'] }}
                            @endif
                        </span>
                    </div>
                    <div class="col-span-6">
                        <span class="font-semibold">
                            Popis:
                        </span>
                        <span class="ml-4">
                            {{ $sourceStream['description'] }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
        <div class="flex justify-between">
            <div>
            </div>
            <div>
                <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4 border-none"
                    wire:click='closeModal' />
            </div>
        </div>
    </x-modal>
</div>
