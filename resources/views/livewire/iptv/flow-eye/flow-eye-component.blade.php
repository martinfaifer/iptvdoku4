@php
    function stringTimeParseToDayMonthYear(string $stringTime)
    {
        $explodedString = explode('T', $stringTime);
        $explodedDate = explode('-', $explodedString[0]);
        $explodedTime = explode('+', $explodedString[1]);

        return $explodedTime[0] . ' ' . $explodedDate[2] . '.' . $explodedDate[1] . ' ' . $explodedDate[0];
    }
@endphp
<div class="overflow-hidden">
    <div class="flex flex-col">
        @if (is_null($ticket))
            <div class="mt-12">
                <x-share.alerts.info title="Vyberte ticket z menu vlevo"></x-share.alerts.info>
            </div>
        @else
            {{-- {{ dd($ticket) }} --}}
            <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                        <a href="{{ $ticket['url'] }}" target="_blank" class="hover:underline">
                            {{ strip_tags($ticket['current_step']['inbox']) }}</a>
                        <div class="absolute right-10 -mt-8">
                            @if (!array_key_exists('resitel', $ticket))
                                <div class="tooltip tooltip-bottom" data-tip="Volný úkol">
                                    <div
                                        class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-red-600 text-neutral-200 rounded-md w-18 h-5">
                                        Bez řešitele
                                    </div>
                                </div>
                            @else
                                <div class="tooltip tooltip-bottom" data-tip="řešitel">
                                    <div
                                        class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 bg-green-600 text-neutral-200 rounded-md w-18 h-5">
                                        {{ $ticket['resitel']['data']['email'] }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </h1>
                </div>
            </div>
            <hr
                class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-none rounded">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mt-4">
                    <x-share.cards.base-card title="">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12">
                                <p>Odesílatel: <span
                                        class="font-semibold">{{ $ticket['variables']['ticket']['data']['contact_email'] }}</span>
                                </p>
                            </div>
                            <div class="col-span-12">
                                <div class="rounded-lg bg-[#082D46] overflow-y-auto max-h-96">
                                    <div class="py-4 px-4">
                                        {!! $ticket['variables']['ticket']['data']['detail'] !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-share.cards.base-card>
                </div>
                <div class="col-span-12 md:col-span-8 mt-4">
                    <x-share.cards.base-card title="Odeslané emaily">
                        <div class="overflow-y-auto h-96">
                            <div class="grid grid-cols-12 gap-4">
                                @foreach ($ticket['discussion'] as $discussion)
                                    @if (str_contains($discussion['message'], 'Odchozí email pro:'))
                                        <div class="col-span-12">
                                            <div class="rounded-lg bg-[#082D46]">
                                                <div class="text-xs text-start font-thin pt-2 px-2">
                                                    {{ $discussion['author']['email'] }}
                                                </div>
                                                <div class="px-4 py-4">
                                                    @php
                                                        $explodedMessage = explode('###', $discussion['message']);
                                                        $explodedMessageArray = explode('-------', $explodedMessage[1]);
                                                        $explodedMessageContent = explode(
                                                            "\n",
                                                            $explodedMessageArray[1],
                                                        );
                                                    @endphp
                                                    <p class="text-xs font-thin">
                                                        {{ str_replace('`', '', $explodedMessage[0]) }}</p>
                                                    <p class="font-semibold text-base my-2">
                                                        {{ $explodedMessageArray[0] }}</p>
                                                    @foreach ($explodedMessageContent as $message)
                                                        <p>{{ $message }}</p>
                                                    @endforeach
                                                </div>
                                                <div class="text-xs text-end font-thin px-2 pb-2">
                                                    {{ stringTimeParseToDayMonthYear($discussion['created_at']) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </x-share.cards.base-card>
                </div>
                <div class="col-span-12 md:col-span-4 mt-4">
                    <x-share.cards.base-card title="Diskuze">
                        <div class="overflow-y-auto h-96">
                            <div class="grid grid-cols-12 gap-4">
                                @foreach ($ticket['discussion'] as $discussion)
                                    @if (!str_contains($discussion['message'], 'Odchozí email pro:'))
                                        <div class="col-span-12">
                                            <div class="rounded-lg bg-[#082D46]">
                                                <div class="text-xs text-start font-thin pt-2 px-2">
                                                    {{ $discussion['author']['email'] }}
                                                </div>
                                                <div class="px-4 py-4">
                                                    {{ $discussion['message'] }}
                                                </div>
                                                <div class="text-xs text-end font-thin px-2 pb-2">
                                                    {{ stringTimeParseToDayMonthYear($discussion['created_at']) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </x-share.cards.base-card>
                </div>
            </div>
        @endif
    </div>
</div>
