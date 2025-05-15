<div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 xl:col-span-8">
            <div class="grid grid-cols-12 gap-4">
                @if (!empty($runningEvents))
                    <div class="col-span-12 mb-6">
                        <p class="font-semibold text-lg">Probíhající události</p>
                        <div class="mt-4">
                            <div class="overflow-auto max-h-80">
                                @foreach ($runningEvents as $event)
                                    <x-list-item wire:key="running-events-{{ $event['id'] }}" :item="$event"
                                        class="bg-sky-600/20 hover:bg-sky-600/50">
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
                                                <div class="col-span-5 dark:text-white/50">
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
                                                                        <span
                                                                            wire:key='runnings-event-channel-{{ $channel->id }}'
                                                                            class="text-sky-300 text-wrap">
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
                                                                                $user->first_name[0] .
                                                                                $user->last_name[0];
                                                                        }
                                                                    @endphp
                                                                    <div wire:key='running-event-user-{{ $user->id }}'
                                                                        class="avatar placeholder">
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

                                                        <div>
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
                                                                            ->createFromFormat(
                                                                                'Y-m-d',
                                                                                $event['end_date'],
                                                                            )
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
                                        <x-slot:actions>
                                            <x-button wire:click="edit({{ $event['id'] }})"
                                                class="btn-sm bg-transparent border-none text-green-500 shadow-none"
                                                icon="o-pencil"></x-button>
                                            <x-button wire:click="destroy({{ $event['id'] }})"
                                                class="btn-sm bg-transparent border-none text-red-500 shadow-none"
                                                icon="o-trash"></x-button>
                                        </x-slot:actions>
                                    </x-list-item>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-span-12">
                    <p class="font-semibold text-lg">
                        Následující události
                    </p>
                    <div class="mt-4">
                        @if (!empty($upcomingEvents))
                            <div class="overflow-auto max-h-[38rem]">
                                @foreach ($upcomingEvents as $event)
                                    <x-list-item wire:key="upcoming-event-{{ $event['id'] }}" :item="$event">
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
                                                    <div class="grid grid-cols-12 gap-4">
                                                        <div class="col-span-12">
                                                            <article>
                                                                {!! Str::markdown($event['description']) !!}
                                                            </article>
                                                        </div>
                                                        <div class="col-span-12 ">
                                                            @if (!is_null($event['banner_path']))
                                                                <img class="object-contain"
                                                                    src="/storage/{{ str_replace('public/', '', $event['banner_path']) }}"
                                                                    alt="" />
                                                            @endif
                                                        </div>
                                                        @if (!is_null($event['sftp_server']))
                                                            <div class="col-span-12">
                                                                <span class="ml-4">
                                                                    SFTP server:
                                                                    <span class="font-semibold">
                                                                        <a href="sftps/{{ $event['sftp_server']['id'] }}"
                                                                            target="_blank" class="hover:underline">
                                                                            {{ $event['sftp_server']['name'] }}
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-span-5 dark:text-white/50">
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
                                                                    <span
                                                                        wire:key='upcoming-event-channel-{{ $channel->id }}'
                                                                        class="text-sky-300">
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
                                                                            $inicials =
                                                                                $user->first_name[0] .
                                                                                $user->last_name[0];
                                                                        }
                                                                    @endphp
                                                                    <div wire:key='upcoming-event-user-{{ $user->id }}'
                                                                        class="avatar placeholder">
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

                                                        <div>
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
                                                                            ->createFromFormat(
                                                                                'Y-m-d',
                                                                                $event['end_date'],
                                                                            )
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
                                        <x-slot:actions>
                                            <x-button wire:click="edit({{ $event['id'] }})"
                                                class="btn-sm bg-transparent border-none text-green-500 shadow-none"
                                                icon="o-pencil"></x-button>
                                            <x-button wire:click="destroy({{ $event['id'] }})"
                                                class="btn-sm bg-transparent border-none text-red-500 shadow-none"
                                                icon="o-trash"></x-button>
                                        </x-slot:actions>
                                    </x-list-item>
                                @endforeach
                            </div>
                        @else
                            <x-share.alerts.info title="Není na dnešek plánována žádná událost"></x-share.alerts.info>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- calendar --}}
        <div class="col-span-12 xl:col-span-4 relative overflow-hidden">
            <div class="grid grid-cols-12 gap-4 md:mt-9">
                <div class="col-span-12">
                    <x-calendar locale="cs" :events="$events" />
                </div>
                <div class="col-span-12 md:mt-4">
                    <livewire:iptv.calendar.create-calendar-event-component>
                </div>
            </div>
        </div>
    </div>

    <x-drawer wire:model="updateModal" right class="lg:w-2/3 !dark:bg-[#0E1E33]">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeModal'>✕</x-button>
            <div class="overflow-y-auto">
                <div class="grid grid-cols-12 gap-4 ">
                    <div class="col-span-12 mb-4">
                        <x-input label="Název události" wire:model="form.label" />
                        <div>
                            @error('label')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 mb-4">
                        <x-input type="date" label="Den začátku události" wire:model="form.start_date" />
                        <div>
                            @error('start_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 mb-4">
                        <x-input type="time" label="Čas začátku události" wire:model="form.start_time" />
                        <div>
                            @error('start_time')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 mb-4">
                        <x-input type="date" label="Den konce události" wire:model="form.end_date" />
                        <div>
                            @error('end_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6 mb-4">
                        <x-input type="time" label="Čas konce události" wire:model="form.end_time" />
                        <div>
                            @error('end_time')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Vyberte kanál/y" wire:model="form.channels" :options="$channels"
                            searchable>
                        </x-choices-offline>
                        <div>
                            @error('users')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Štítek s akcí" wire:model="form.tag_id" :options="$tags" searchable
                            single>
                        </x-choices-offline>
                        <div>
                            @error('users')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Vyberte uživatele pro upozornění" wire:model="form.users"
                            :options="$users" option-label="email" searchable>
                        </x-choices-offline>
                        <div>
                            @error('users')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4 md:mt-10">
                        <x-checkbox label="Zobrazit upozornění v banneru?" wire:model="form.fe_notification" />
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Barva" wire:model="form.color" :options="$cssColors"
                            option-label="color" single searchable>
                            @scope('item', $cssColor)
                                <x-list-item :item="$cssColor" sub-value="color">
                                    <x-slot:avatar>
                                        <x-share.cards.color-card
                                            color="{{ $cssColor->color }}"></x-share.cards.color-card>
                                    </x-slot:avatar>
                                </x-list-item>
                            @endscope

                            @scope('selection', $cssColor)
                                <x-share.cards.color-card color="{{ $cssColor->color }}"></x-share.cards.color-card>
                            @endscope
                        </x-choices-offline>
                    </div>
                    <div class="col-span-12 md:col-span-6 mb-4">
                        <x-choices-offline label="Vyberte server pro nahrání banneru" wire:model="form.sftp_server_id"
                            :options="$sftpServers" single searchable>
                        </x-choices-offline>
                    </div>
                    <div class="col-span-12 mb-4">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-file class="!file-input-xs" label="Zde můžete nahrát banner"
                                    wire:model="form.banner" accept="image/png" />
                            </div>
                            <div class="col-span-6">
                                @if (!is_null($form->banner))
                                    <span class="text-sm font-semibold">Již nahraný banner</span>
                                    <img class="object-contain mt-2"
                                        src="/storage/{{ str_replace('public/', '', $form->banner) }}"
                                        alt="" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 mb-4">
                        <template x-if="$wire.updateModal">
                            <x-markdown wire:model="form.description" label="Popis události" />
                        </template>
                    </div>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28" wire:click='closeModal' />
                </div>
                <div>
                    <x-button label="Upravit" class="btn btn-doku-primary w-full sm:w-28" type="submit"
                        spinner="update" />
                </div>
            </div>
        </x-form>
    </x-drawer>
</div>
