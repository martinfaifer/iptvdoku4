<div>
    <table class="table table-xs md:table-sm w-full text-[#A3ABB8]">
        <!-- head -->
        <thead>
            <tr>
                <th class="w-1/2">Kanál</th>
                <th class="w-1/2">Záloha</th>
            </tr>
        </thead>
        <tbody class="overflow-y h-1/3">
            @if (!is_null($channels))
                @foreach ($channels as $channel)
                    @php
                        $channelDetailOnDevice = $this->get_channel($channel);
                    @endphp
                    @if (!is_null($channelDetailOnDevice))
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
                @endforeach
            @endif
        </tbody>
    </table>
</div>
