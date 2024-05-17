<div>
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                Vaše akce v dokumentaci
            </h1>
        </div>
    </div>
    <hr class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-none rounded">
    <div class="grid grid-cols-12 gap-4 mt-6">
        {{-- notes --}}
        <div class="col-span-12 xl:col-span-6">
            <p class="font-semibold ml-2 my-2">Poznámky</p>
            <x-share.cards.base-card title="">
                <div class="h-44">
                    @if ($notes->isEmpty())
                        <div>
                            <x-share.alerts.info title="Neexistuje žádná poznámka"></x-share.alerts.info>
                        </div>
                    @else
                        <div class="grid grid-cols-12">
                            <div class="col-span-12">
                                <div class="overflow-y-auto h-36">
                                    @foreach ($notes as $note)
                                        <div class="chat chat-start">
                                            <div class="chat-bubble w-full">
                                                {{ $note->note }}
                                            </div>
                                            <div class="chat-footer opacity-50">
                                                <time class="text-xs opacity-50">{{ $note->created_at }}</time>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-share.cards.base-card>
        </div>

        {{-- calendar --}}
        {{-- notes --}}
        <div class="col-span-12 xl:col-span-6">
            <p class="font-semibold ml-2 my-2">Události v kalendáři</p>
            <x-share.cards.base-card title="">
                <div class="h-44">
                    @if ($events->isEmpty())
                        <div>
                            <x-share.alerts.info title="Neexistuje žádná událost"></x-share.alerts.info>
                        </div>
                    @else
                        <div class="grid grid-cols-12">
                            <div class="col-span-12">
                                <div class="overflow-y-auto h-36">
                                    @foreach ($events as $event)
                                        <div class="chat chat-start">
                                            <div class="chat-bubble w-full">
                                                {{ $event->description }}
                                            </div>
                                            <div class="chat-footer opacity-50">
                                                <time class="text-xs opacity-50">{{ $event->created_at }}</time>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-share.cards.base-card>
        </div>
    </div>
</div>
