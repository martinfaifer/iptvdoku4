@php
    $outgoingheaders = [
        [
            'key' => 'stream',
            'label' => 'Stream',
            'class' => 'text-[#A3ABB8]',
        ],
        [
            'key' => 'paused',
            'label' => 'Pozastaveno',
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
@endphp
<div>
    <x-share.cards.base-card title="Nimble API">
        <div class="grid grid-cols-12 gap-4 mt-4">
            <div class="col-span-12 overflow-y-scroll max-h-36">
                <p class="text-center">Výstupní streamy</p>
                <x-table :headers="$outgoingheaders" :rows="$outcomingStreams">
                    @scope('cell_paused', $outcomingStream)
                        @if ($outcomingStream['paused'] != 'false')
                            <x-heroicon-o-check class="h-4 w-4 text-green-500" />
                        @else
                            <x-heroicon-o-x-mark class="h-4 w-4 text-red-500" />
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
                            {{ $source['description'] }}
                            <button wire:click='openSourceDetailStream({{ json_encode($source) }})'
                                class="btn btn-sm btn-circle border-none bg-transparent ml-4 -mt-1">
                                <x-heroicon-o-magnifying-glass class="w-4 h-4 text-blue-500" />
                            </button>
                        </div>
                    @endscope
                </x-table>
            </div>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model="detailModal" title="Informace o vstupním streamu">
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
                            {{ $sourceStream['ip'] }}:{{ $sourceStream['port'] }}
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
                <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                    wire:click='closeModal' />
            </div>
        </div>
    </x-modal>
</div>
