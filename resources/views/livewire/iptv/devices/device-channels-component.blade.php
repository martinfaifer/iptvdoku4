<div>
    <x-share.cards.base-card title="Kanály na zařízení">
        <div class="h-44 overflow-y-auto">
            <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <input wire:model.live='search' type="text" placeholder="Vyhledejte ..."
                        class="input input-bordered input-sm bg-opacity-20 text-white placeholder:text-xs w-full md:w-96 mb-4" />
                </div>
                <div class="col-span-12 mb-4 ">
                    <table class="table table-xs md:table-sm w-full dark:text-[#A3ABB8]">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th class="w-1/2">Kanál</th>
                                <th class="w-1/2">Záloha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!is_null($channels))
                                @foreach ($channels as $channel)
                                    @php
                                        $channelDetailOnDevice = $this->get_channel($channel);
                                    @endphp
                                    @if (!is_null($channelDetailOnDevice))
                                        @if (blank($search))
                                            <tr class="cursor-pointer hover:bg-slate-800/5 hover:dark:bg-slate-600 "
                                                href="/channels/{{ $channelDetailOnDevice['id'] }}/{{ $channelDetailOnDevice['channelType'] }}"
                                                wire:navigate>
                                                <td>{{ $channelDetailOnDevice['name'] }}
                                                    {{ $channelDetailOnDevice['channelType'] }}</td>
                                                <td>
                                                    @if ($channelDetailOnDevice['isBackup'] == true)
                                                        <x-heroicon-s-check class="text-green-500 h-4 w-4" />
                                                    @else
                                                        <x-heroicon-o-x-mark class="text-red-500 h-4 w-4" />
                                                    @endif
                                                </td>
                                            </tr>
                                        @elseif (str_contains(strtolower($channelDetailOnDevice['name']), strtolower($search)))
                                            <tr class="cursor-pointer hover:bg-slate-600 "
                                                href="/channels/{{ $channelDetailOnDevice['id'] }}/{{ $channelDetailOnDevice['channelType'] }}"
                                                wire:navigate>
                                                <td>{{ $channelDetailOnDevice['name'] }}
                                                    {{ $channelDetailOnDevice['channelType'] }}</td>
                                                <td>
                                                    @if ($channelDetailOnDevice['isBackup'] == true)
                                                        <x-heroicon-s-check class="text-green-500 h-4 w-4" />
                                                    @else
                                                        <x-heroicon-o-x-mark class="text-red-500 h-4 w-4" />
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-share.cards.base-card>
</div>
