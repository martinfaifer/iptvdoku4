@php
    $devicesAllowsRestartChannel = [];
    $channelsOnDevice = [];
    $ipBelongsToChannel = [];

    function get_channel($channelWithType): ?array
    {
        $explodedChannelWithType = explode(':', $channelWithType);

        return [
            'id' => $explodedChannelWithType[1],
            'channelType' => $explodedChannelWithType[0],
            'name' => App\Models\Channel::find($explodedChannelWithType[1])->name,
            'isBackup' => isset($explodedChannelWithType[3]) ? true : false,
        ];
    }

    $devicesWithBoundOnTagAction = App\Models\TagOnItem::onlyDevicesWithTag(
        App\Models\Tag::hasActionChannelRestart()->first()?->id,
    )->get();
    foreach ($devicesWithBoundOnTagAction as $deviceIdWithBoundOnTagAction) {
        array_push(
            $devicesAllowsRestartChannel,
            App\Models\Device::find($deviceIdWithBoundOnTagAction->item_id)->only(['id', 'name']),
        );
    }

    if (!is_null($createForm->deviceId)) {
        $channels = App\Models\Device::find($createForm->deviceId)->only('has_channels');
        if (!is_null($channels['has_channels'])) {
            foreach ($channels['has_channels'] as $channel) {
                array_push($channelsOnDevice, get_channel($channel));
            }
        }
    }

    if (!is_null($createForm->channelId)) {
        foreach ($channels['has_channels'] as $singleChannel) {
            $explodedChannel = explode(':', $singleChannel);
            if ($createForm->channelId == $explodedChannel[1]) {
                // search form channel and ips
                if ($explodedChannel[0] == 'h265') {
                    $ips = App\Models\Channel::find($explodedChannel[1])->load('h265.ips');
                    $ipBelongsToChannel = $ips->h265->ips;
                }

                if ($explodedChannel[0] == 'h264') {
                    $ips = App\Models\Channel::find($explodedChannel[1])->load('h264.ips');
                    $ipBelongsToChannel = $ips->h264->ips;
                }
            }
        }
    }
@endphp
<div>
    <x-share.cards.base-card title="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 md:col-span-9 ">
                <x-input placeholder="Vyhledejte ..." wire:model.live="query" class="input-md placeholder:text-gray-600"
                    icon="o-magnifying-glass" autofocus />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-button
                    class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm mt-2 absolute right-5 md:right-10"
                    wire:click="openCreateModal">
                    + Nová vazba
                </x-button>
            </div>
        </div>

        <div>
            <x-table :headers="$headers" :rows="$channelsFroRestart" with-pagination>
                @scope('cell_actions', $channel)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $channel->id }})" wire:confirm="Opravdu odebrat?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>
    <p class="text-sm text-white/60 italic ml-3 mt-1">Funkce je dostupná pouze pro H264 a H265</p>
    <p class="text-sm text-white/60 italic ml-3 mt-1">Streamy budou restartovány v
        <span class="font-semibold text-red-500/80">03:00 každý den</span>
    </p>

    {{-- create modal --}}
    <x-modal wire:model.live="createModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Vyberte zařízení" wire:model.live="createForm.deviceId" :options="$devicesAllowsRestartChannel"
                        single searchable />
                </div>
                <div class="col-span-12">
                    <x-choices label="Vyberte kanál" wire:model.live="createForm.channelId" :options="$channelsOnDevice" single>
                    </x-choices>
                </div>
                <div class="col-span-12">
                    <x-choices-offline label="Vyberte url" wire:model.live="createForm.ip" :options="$ipBelongsToChannel"
                        option-label="ip" single searchable />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
