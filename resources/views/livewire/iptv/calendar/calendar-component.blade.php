<div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-8">
            <p class="font-semibold text-lg">
                Následující události
            </p>
            <div class="mt-4">
                @if (!empty($upcomingEvents))
                    <div class="overflow-auto max-h-[38rem]">
                        @foreach ($upcomingEvents as $event)
                            <x-list-item :item="$event">
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
                                        <div class="col-span-5  text-white/50">
                                            <div class="grid grid-rows-2 gap-4">
                                                <div>
                                                    @if (!is_null($event['users']))
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
                                <x-slot:actions>
                                    <x-dropdown>
                                        <x-slot:trigger>
                                            <x-button label="..." class="btn btn-outline border-none text-white" />
                                        </x-slot:trigger>

                                        <x-menu-item wire:click="edit({{ $event['id'] }})" icon="o-pencil"
                                            class="text-green-500" title="Upravit" />
                                        <x-menu-item wire:click="destroy({{ $event['id'] }})"
                                            wire:confirm='Opravdu odebrat událost?' icon="o-trash" class="text-red-500"
                                            title="Odebrat" />
                                    </x-dropdown>
                                </x-slot:actions>
                            </x-list-item>
                        @endforeach
                    </div>
                @else
                    <x-share.alerts.info title="Není na dnešek plánována žádná událost"></x-share.alerts.info>
                @endif
            </div>
        </div>
        <div class="col-span-12 md:col-span-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-calendar locale="cs" :events="$events" weekend-highligh />
                </div>
                <div class="col-span-12">
                    <livewire:iptv.calendar.create-calendar-event-component>
                </div>
            </div>
        </div>
    </div>

    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeModal'>✕</x-button>
            <div class="grid grid-cols-12 gap-4 ">
                <div class="overflow-y-auto !h-36">
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
                    <div class="col-span-12 mb-4">
                        <x-textarea wire:model="form.description" rows="5" inline />
                        {{-- <x-markdown wire:model="form.description" label="Popis události" /> --}}
                    </div>
                </div>
            </div>

            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeModal' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28" type="submit"
                        spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
