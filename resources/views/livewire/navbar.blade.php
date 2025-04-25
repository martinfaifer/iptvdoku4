<div>
    <div
        class="navbar fixed bg-gradient-to-r from-slate-900/20 to-sky-950/20 mb-1 top-0 right-0 z-10 min-h-8 backdrop-blur-xl">
        <div class="flex-1">
            <label for="sidebar-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </div>
        <div class="flex gap-4">
            <div class="form-control">
                <input @click.stop="$dispatch('mary-search-open')" type="text" placeholder="Vyhledejte ... ctrl+space"
                    class="input input-bordered input-sm bg-transparent shadow-none text-white placeholder:text-xs w-full md:w-auto" />
            </div>
            <div>
                <label @click='$wire.openCalendarEventsDrawer' class="btn btn-sm btn-circle bg-transparent border-none">
                    <x-heroicon-o-calendar-days @class([
                        'size-6',
                        'text-white/80' => !empty($runningEvents),
                        'text-white/20' => empty($runningEvents),
                    ]) fill="none" />
                </label>
            </div>
            {{-- weather --}}
            <div>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-circle btn-ghost btn-sm text-info">

                        <div>
                            <img class="object-cover size-6" src="{{ $this->get_icon($weather) }}" alt="" />
                        </div>

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    @if (!empty($weather))
                        <div tabindex="0"
                            class="hidden md:block card compact dropdown-content z-[1] shadow bg-[#0c111b] rounded-box w-96">
                            <div tabindex="0" class="card-body">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-12">
                                        <div class="grid grid-cols-12 gap-4">
                                            <div class="col-span-7">
                                                <p class="text-2xl font-bold">
                                                    {{ $weather['location'] }}
                                                </p>
                                            </div>
                                            <div class="col-span-5 inline-flex -ml-3">
                                                <div class="avatar">
                                                    <div class="w-8 rounded-full">
                                                        <img src="{{ $this->get_icon($weather) }}" alt="" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-2xl font-bold ml-2">
                                                        {{ $weather['temp'] }}°C
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <hr
                                            class="w-full h-[1px] -mt-4 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-none rounded">
                                    </div>
                                    <div class="col-span-12 md:col-span-6">
                                        <p class="font-semibold">
                                            Rychlost větru: {{ $weather['windSpeed'] }}m/s
                                        </p>
                                    </div>
                                    <div class="col-span-12 md:col-span-6">
                                        <p class="font-semibold">
                                            Vlhkost: {{ $weather['humidity'] }}%
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-sm btn-ghost btn-circle avatar border">
                        @if (is_null($user->avatar_url))
                            <span class="text-sm">
                                {{ $user->first_name[0] }}
                                {{ $user->last_name[0] }}
                            </span>
                        @else
                            <img class="object-contain rounded-full"
                                src="{{ config('app.url') . '/' . $user->avatar_url }}" alt="" />
                        @endif
                    </div>
                    <ul tabindex="0"
                        class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-[#0e151f] bg-clip-padding backdrop-filter
                    backdrop-blur-sm rounded-box w-52">
                        <li>
                            <a class="justify-between" href="/profile" wire:navigate>
                                Profil
                            </a>
                        </li>
                        @can('show_settings_link', App\Models\User::class)
                            <li><a href="/settings/dashboard" wire:navigate>Nastavení</a></li>
                        @endcan
                        <li class="hover:bg-red-500/30 hover:text-red-400/80 rounded-md" @click='$wire.logout()'><a>Odhlásit se</a></li>
                        <hr
                            class="w-full mx-auto h-[1px] mt-[2px] bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                        <span class="mt-[2px] text-center text-[10px] text-white/50">Verze: {{ config('version.version') }}</span>
                    </ul>
                </div>
            </div>
            <div>
                <livewire:navbar-streams-notification-component
                    wire:poll.15s></livewire:navbar-streams-notification-component>
            </div>
        </div>
    </div>
    {{-- alert drawer --}}

    {{-- calendar events drawer --}}
    <x-drawer wire:model='calendarEventsDrawer' class="lg:w-1/4 !bg-[#0E1E33]" right>
        @if (!empty($runningEvents))
            <div class="col-span-12 mb-6">
                <p class="font-semibold text-lg">Probíhající události</p>
                <div class="mt-4">
                    <div class="overflow-auto max-h-80">
                        @foreach ($runningEvents as $event)
                            <x-list-item wire:key="$event->id" :item="$event"
                                class="bg-sky-600/20 hover:bg-sky-600/50 mb-2 rounded-lg">
                                <x-slot:avatar>
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral text-neutral-content rounded-full w-11">
                                            <span class="text-lg">
                                                {{ $event['user']['first_name'][0] }}
                                                {{ $event['user']['last_name'][0] }}
                                            </span>
                                        </div>
                                    </div>
                                </x-slot:avatar>
                                <x-slot:value>
                                    {{ $event['label'] }}
                                </x-slot:value>
                                <x-slot:sub-value>
                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-7">
                                            <article>
                                                {!! Str::markdown($event['description']) !!}
                                            </article>
                                        </div>
                                        <div class="col-span-5 text-white/50">
                                            <div class="grid grid-rows-1 gap-1 text-xs">
                                                {{-- channels --}}
                                                <div>
                                                    @if (!is_null($event['channels']) && !empty(json_decode($event['channels'])))
                                                        <span class="font-semibold">
                                                            Kanály:
                                                        </span>
                                                        @foreach (json_decode($event['channels']) as $channelId)
                                                            @php
                                                                $channel = null;
                                                                $channel = App\Models\Channel::find($channelId);
                                                            @endphp
                                                            @if (!is_null($channel))
                                                                <span class="text-sky-300 text-wrap">
                                                                    <a target="_blank" class="hover:underline"
                                                                        href="channels/{{ $channel->id }}/multicast">{{ $channel->name }}</a>
                                                                    ,
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div>
                                                    @if (!is_null($event['users']) && !empty(json_decode($event['users'])))
                                                        <span class="font-semibold">
                                                            Uživatelé co jsou upozornění:
                                                        </span>
                                                        @foreach (json_decode($event['users']) as $userId)
                                                            @php
                                                                $user = App\Models\User::find($userId);

                                                                if ($user) {
                                                                    $inicials =
                                                                        $user->first_name[0] . $user->last_name[0];
                                                                }
                                                            @endphp
                                                            <div class="avatar placeholder">
                                                                <div
                                                                    class="bg-neutral text-neutral-content rounded-full w-8">
                                                                    <span class="text-md">
                                                                        {{ $inicials }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>

                                                <div class="text-wrap">
                                                    @php
                                                        $formtedStartDate = now()
                                                            ->createFromFormat('Y-m-d', $event['start_date'])
                                                            ->format('d.m. Y');
                                                    @endphp
                                                    {{ $formtedStartDate }} {{ $event['start_time'] }}
                                                    @if (!is_null($event['end_date']) || !is_null($event['end_time']))
                                                        -
                                                        @php
                                                            $formtedEndDate = '';
                                                            if (!is_null($event['end_date'])) {
                                                                $formtedEndDate = now()
                                                                    ->createFromFormat('Y-m-d', $event['end_date'])
                                                                    ->format('d.m. Y');
                                                            }
                                                        @endphp
                                                        {{ $formtedEndDate }} {{ $event['end_time'] }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </x-slot:sub-value>
                            </x-list-item>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="col-span-12">
                <x-share.alerts.info title="Neprobíhají žádné události"></x-share.alerts.info>
            </div>
        @endif
    </x-drawer>

    <x-modal wire:model="calendarNotificationDialog" persistent class="modal-bottom sm:modal-middle fixed">
        <x-button class="btn btn-sm btn-circle btn-ghost fixed right-2 top-2"
            wire:click='closeCalendarNotificationDialog'>✕</x-button>
        <div class="overflow-y-auto h-96">
            <div class="grid grid-cols-12 gap-4 text-sm">
                @foreach ($notifyFromCurrentEvents as $currentEvent)
                    <div class="col-span-12">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12">
                                <p class="text-lg font-bold">Událost: {{ $currentEvent['label'] }}</p>
                            </div>
                            <div class="col-span-12 mt-4">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-6">
                                        <p class="text-sm">
                                            Start události: <span
                                                class="font-semibold">{{ $currentEvent['start_date'] }}
                                                {{ $currentEvent['start_time'] }}</span>
                                        </p>
                                    </div>
                                    <div class="col-span-6">
                                        <p class="text-sm">
                                            Konec události: <span
                                                class="font-semibold">{{ $currentEvent['end_date'] }}
                                                {{ $currentEvent['end_time'] }}</span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-span-12 sm:col-span-6 md:mt-4">
                                <p>Událost vytvořil: <span class="font-semibold">{{ $currentEvent['creator'] }}</span>
                                </p>
                            </div>
                            <div class="col-span-12 sm:col-span-6 md:mt-4">
                                @if (!is_null($event['users']) && !empty(json_decode($event['users'])))
                                    <span class="font-semibold">
                                        Uživatelé co jsou upozornění:
                                    </span>
                                    @foreach (json_decode($event['users']) as $userId)
                                        @php
                                            $user = App\Models\User::find($userId);

                                            if ($user) {
                                                $inicials = $user->first_name[0] . $user->last_name[0];
                                            }
                                        @endphp
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                <span class="text-md">
                                                    {{ $inicials }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-span-12 mt-4">
                                <div class="rounded-lg border border-[#082F48]">
                                    <article class="text-sm mx-2 my-2">
                                        {!! Str::markdown($currentEvent['description']) !!}
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-modal>
</div>
