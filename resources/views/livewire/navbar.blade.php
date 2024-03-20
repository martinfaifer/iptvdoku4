<div>
    <div class="navbar fixed bg-[#06090e] bg-opacity-20 mb-1 top-0 right-0 z-10 min-h-8 backdrop-blur-md">
        <div class="flex-1">

        </div>
        <div class="flex-none gap-4">
            <div class="form-control">
                <input @click.stop="$dispatch('mary-search-open')" type="text" placeholder="Vyhledejte ... ctrl+space"
                    class="input input-bordered input-sm bg-opacity-20 text-white placeholder:text-xs w-24 md:w-auto" />
            </div>
            <div>
                <label for="calendarEventsDrawer" class="btn btn-sm btn-circle bg-transparent border-none">
                    <x-heroicon-o-calendar-days @class([
                        'size-6',
                        'text-white/80' => !empty($runningEvents),
                        'text-white/20' => empty($runningEvents),
                    ]) fill="none" />
                </label>
            </div>
            {{-- weather --}}
            <div>
                {{-- <button class="btn btn-sm btn-circle border-none bg-transparent" wire:click='openWeatherModal()'>
                    <img class="object-cover size-6" src="/storage/svgs/sunny.svg" alt="" />
                </button> --}}
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-circle btn-ghost btn-sm text-info">
                        @if (!empty($weather))
                            <div>
                                @if (str_contains($weather['description'], 'rain'))
                                    <img class="object-cover size-6" src="/storage/svgs/rain.svg" alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'thunderstorm'))
                                    <img class="object-cover size-6" src="/storage/svgs/thunderstorm.svg"
                                        alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'drizzle'))
                                    <img class="object-cover size-6" src="/storage/svgs/rain.svg" alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'snow'))
                                    <img class="object-cover size-6" src="/storage/svgs/snow.svg" alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'mist'))
                                    <img class="object-cover size-6" src="/storage/svgs/smoke.svg" alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'smoke'))
                                    <img class="object-cover size-6" src="/storage/svgs/smoke.svg" alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'tornado'))
                                    <img class="object-cover size-6" src="/storage/svgs/tornado.svg" alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'clear sky'))
                                    <img class="object-cover size-6" src="/storage/svgs/sunny.svg" alt="" />
                                @endif
                                @if (str_contains($weather['description'], 'clouds'))
                                    <img class="object-cover size-6" src="/storage/svgs/clouds.svg" alt="" />
                                @else
                                    <img class="object-cover size-6" src="/storage/svgs/sunny.svg" alt="" />
                                @endif
                            </div>
                        @else
                            <img class="object-cover size-6" src="/storage/svgs/sunny.svg" alt="" />
                        @endif

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    @if (!empty($weather))
                        <div tabindex="0"
                            class="card compact dropdown-content z-[1] shadow bg-base-100 rounded-box w-96">
                            <div tabindex="0" class="card-body">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-12">
                                        <div class="grid grid-cols-12 gap-4">
                                            <div class="col-span-8">
                                                <p class="text-2xl font-bold">
                                                    {{ $weather['location'] }}
                                                </p>
                                            </div>
                                            <div class="col-span-4 inline-flex">
                                                <div>
                                                    @if (str_contains($weather['description'], 'rain'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/rain.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'thunderstorm'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/thunderstorm.svg"
                                                                    alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'drizzle'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/rain.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'snow'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/snow.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'mist'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/smoke.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'smoke'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/smoke.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'tornado'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/tornado.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'clear sky'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/sunny.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (str_contains($weather['description'], 'clouds'))
                                                        <div class="avatar">
                                                            <div class="w-8 rounded-full">
                                                                <img src="/storage/svgs/clouds.svg" alt="" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-2xl font-bold">
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
                        <span class="text-sm">
                            {{ $user->first_name[0] }}
                            {{ $user->last_name[0] }}
                        </span>

                    </div>
                    <ul tabindex="0"
                        class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-[#0e151f] bg-clip-padding backdrop-filter
                    backdrop-blur-sm rounded-box w-52">
                        <li>
                            <a class="justify-between" href="/profile" wire:navigate>
                                Profil
                            </a>
                        </li>
                        <li><a href="/settings" wire:navigate>Nastavení</a></li>
                        <li wire:click='logout()'><a>Odhlásit se</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <label for="alert-drawer" class="btn btn-sm btn-circle bg-transparent border-none">
                    <x-heroicon-c-bell @class([
                        'h-6 w-6',
                        'text-red-500' => !empty($iptv_dohled_alerts),
                        'text-gray-500' => empty($iptv_dohled_alerts),
                    ]) />
                    @if (!empty($iptv_dohled_alerts))
                        <div class="text-white text-sm bg-red-500 rounded-full fixed w-5 h-5 ml-4 mt-3">
                            {{ count($iptv_dohled_alerts) }}
                        </div>
                    @endif
                </label>
            </div>
        </div>
    </div>
    {{-- alert drawer --}}
    <x-drawer id="alert-drawer" right class="lg:w-1/4 !bg-[#0c111b]">
        {{-- alerts --}}
        @if (!empty($iptv_dohled_alerts))
            @foreach ($iptv_dohled_alerts as $iptv_dohled_alert)
                <div role="alert" class="alert alert-error mb-3 text-gray-100 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $iptv_dohled_alert['nazev'] }}</span>
                </div>
            @endforeach
        @endif
    </x-drawer>
    {{-- calendar events drawer --}}
    <x-drawer id="calendarEventsDrawer" class="lg:w-1/4 !bg-[#0c111b]" right>
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
                                                {!! $event['description'] !!}
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
                                                            <span class="text-sky-300 text-wrap">
                                                                <a target="_blank" class="hover:underline"
                                                                    href="channels/{{ $channel->id }}/multicast">{{ $channel->name }}</a>
                                                                ,
                                                            </span>
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
                                                                    $inicials = $user->first_name[0] . $user->last_name[0];
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
</div>
