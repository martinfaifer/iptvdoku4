<div wire:poll>
    @if (!$isClosed)
        @if (!$isMinimaze)
            <div @class([
                'invisible xl:visible fixed z-50 right-1 bottom-1 bg-[#0f172a]  shadow-2xl shadow-sky-800 rounded-lg w-2/6 h-96',
            ])>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <p class="text-center text-sm font-semibold mt-2">Nefunkční kanály</p>
                        <button @click='$wire.minimizeWindow()'
                            class="btn btn-circle btn-outline btn-xs border-none bg-transparent absolute right-8 top-1 text-blue-500">
                            <x-heroicon-o-chevron-down class="size-4" />
                        </button>
                        <button @click='$wire.closeWindow()'
                            class="btn btn-circle btn-outline btn-xs border-none bg-transparent absolute right-1 top-1 text-red-500">
                            <x-heroicon-o-x-circle class="size-4" />
                        </button>
                    </div>
                    <div class="col-span-12 mx-4 my-4">
                        @if (blank($alerts))
                            <x-share.alerts.info title="Nebyl nalezen žádný problém"></x-share.alerts.info>
                        @elseif (is_array($alerts) && count($alerts['data']) == 0)
                            <x-share.alerts.info title="Nebyl nalezen žádný problém"></x-share.alerts.info>
                        @else
                            <div class="grid grid-cols-12">
                                <div class="col-span-12 mt-4">
                                    <div class=" fixed h-72 overflow-y-auto">
                                        <table class="table table-xs">
                                            <!-- head -->
                                            <thead>
                                                <th>Kanál</th>
                                                <th>URL</th>
                                                <th>Status</th>
                                                <th>Výpadek od</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($alerts['data'] as $alert)
                                                    @php
                                                        $can_not_start = false;
                                                        if ($alert['status'] == 'can_not_start') {
                                                            $can_not_start = true;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td @class([
                                                            '!bg-orange-800 font-semibold',
                                                            '!bg-red-800' => $can_not_start,
                                                        ])>
                                                            {{ $alert['name'] }}
                                                        </td>
                                                        <td @class([
                                                            '!bg-orange-800 font-semibold',
                                                            '!bg-red-800' => $can_not_start,
                                                        ])>
                                                            @php
                                                                $streamUrl = $alert['stream_url'];
                                                            @endphp
                                                            <span wire:click="toStream('{{ $streamUrl }}')"
                                                                class=" cursor-pointer underline decoration-dotted hover:decoration-solid">
                                                                {{ $alert['stream_url'] }}
                                                            </span>
                                                        </td>
                                                        <td @class([
                                                            'font-semibold',
                                                            '!bg-orange-800',
                                                            '!bg-red-800' => $can_not_start,
                                                        ])>
                                                            @if ($alert['status'] == 'can_not_start')
                                                                Výpadek
                                                            @endif
                                                            @if ($alert['status'] == 'pts_problem')
                                                                Problém s I frame
                                                            @endif
                                                        </td>
                                                        <th @class(['!bg-orange-800', '!bg-red-800' => $can_not_start])>
                                                            @php
                                                                $time = Carbon\Carbon::parse($alert['updated_at']);
                                                            @endphp
                                                            {{ $time->diffForHumans() }}
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($isMinimaze)
            <div @class([
                'invisible xl:visible fixed z-50 right-1 bottom-1 bg-[#0f172a]  shadow-2xl shadow-sky-800 rounded-lg w-2/6 h-12',
            ])>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <div class="flex">
                            <p class="text-start text-sm font-semibold mt-2 ml-4">Počet nefunkčních kanálů
                                @php

                                    if (blank($alerts)) {
                                        $numberOfAlerts = 0;
                                    } elseif (is_array($alerts) && count($alerts['data']) == 0) {
                                        $numberOfAlerts = 0;
                                    } else {
                                        $numberOfAlerts = count($alerts['data']);
                                    }
                                @endphp
                            </p>
                            <div @class([
                                'size-6 rounded-full inline-block ml-12 mt-2',
                                'bg-red-500' => $numberOfAlerts != 0,
                                'bg-green-500' => $numberOfAlerts == 0,
                            ])>
                                <p @class(['italic font-semibold text-center text-black'])>
                                    {{ $numberOfAlerts }}
                                </p>

                            </div>
                        </div>

                        <button @click='$wire.maximizeWindow()'
                            class="btn btn-circle btn-outline btn-xs border-none bg-transparent absolute right-8 top-1 text-blue-500">
                            <x-heroicon-o-chevron-up class="size-4" />
                        </button>
                        <button @click='$wire.closeWindow()'
                            class="btn btn-circle btn-outline btn-xs border-none bg-transparent absolute right-1 top-1 text-red-500">
                            <x-heroicon-o-x-circle class="size-4" />
                        </button>
                    </div>

                </div>
            </div>
        @endif
    @endif
</div>
