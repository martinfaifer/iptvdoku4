<div wire:poll.30s>
    <x-share.cards.base-card title="Streamy na transcodéru">
        <div class="grid grid-cols-12 gap-4 mt-4">
            <div class="col-span-12 overflow-y-scroll max-h-36">
                <x-table :headers="$headers" :rows="$channelsOnDevice">
                    @scope('cell_status', $channelOnDevice)
                        @if ($channelOnDevice['status'] == 'active')
                            <span class="text-green-500 font-semibold">Aktivní</span>
                        @else
                            <span class="text-red-500 font-semibold">Neaktivní</span>
                        @endif
                    @endscope
                    @scope('cell_actions', $channelOnDevice)
                        {{-- pause stream --}}
                        @if ($channelOnDevice['status'] == 'active')
                            <button wire:click="pause({{ $channelOnDevice['pid'] }})" wire:loading.class.remove='text-red-500'
                                wire:target='pause({{ $channelOnDevice['pid'] }})'
                                class="btn btn-sm btn-circle border-none bg-transparent shadow-sm hover:shadow-red-500/50 text-red-500">
                                <x-heroicon-o-pause-circle class="size-5" />
                            </button>
                        @else
                            <button wire:click="play({{ $channelOnDevice['id'] }})" wire:loading.class.remove='text-blue-500'
                                wire:target='play({{ $channelOnDevice['id'] }})'
                                class="btn btn-sm btn-circle border-none bg-transparent shadow-sm hover:shadow-blue-500/50 text-blue-500">
                                <x-heroicon-o-play-circle class="size-5" />
                            </button>
                        @endif
                    @endscope
                </x-table>
            </div>
        </div>
    </x-share.cards.base-card>
</div>
