<x-share.cards.base-card title="Schéma zapojení kanálu">
    <div class="overflow-x-auto">
        <div class="flex flex-none gap-2 justify-center">
            @foreach ($devices as $device)
                @if ($device->category->name == 'Satelity')
                    <div class="">
                        <x-share.cards.schema-card id="{{ $device->id }}" name="{{ $device->name }}"
                            category="{{ $device->category->name }}"></x-share.cards.schema-card>
                    </div>
                @endif
            @endforeach
            @foreach ($devices as $device)
                @if ($device->category->name == 'Paraboly')
                    <div class="">
                        <x-share.arrows.left-arrow></x-share.arrows.left-arrow>
                    </div>
                    <div class="">
                        <x-share.cards.schema-card id="{{ $device->id }}" name="{{ $device->name }}"
                            category="{{ $device->category->name }}"></x-share.cards.schema-card>
                    </div>
                @endif
            @endforeach

            @foreach ($devices as $device)
                @if ($device->category->name == 'Multiswitche')
                    <div class="">
                        <x-share.arrows.left-arrow></x-share.arrows.left-arrow>
                    </div>
                    <div class="">
                        <x-share.cards.schema-card id="{{ $device->id }}" name="{{ $device->name }}"
                            category="{{ $device->category->name }}"></x-share.cards.schema-card>
                    </div>
                @endif
            @endforeach


            @foreach ($devices as $device)
                @if ($device->category->name == 'Satelitní přijímač')
                    <div class="">
                        <x-share.arrows.left-arrow></x-share.arrows.left-arrow>
                    </div>
                    <div class="">
                        <x-share.cards.schema-card id="{{ $device->id }}" name="{{ $device->name }}"
                            category="{{ $device->category->name }}"></x-share.cards.schema-card>
                    </div>
                @endif
            @endforeach


            @foreach ($devices as $device)
                @if ($device->category->name == 'Po IP')
                    <div class="">
                        <x-share.cards.schema-card id="{{ $device->id }}" name="{{ $device->name }}"
                            category="{{ $device->category->name }}"></x-share.cards.schema-card>
                    </div>
                @endif
            @endforeach

            @foreach ($devices as $device)
                @if ($device->category->name == 'Multiplexor')
                    <div class="">
                        <x-share.arrows.left-arrow></x-share.arrows.left-arrow>
                    </div>
                    <div class="">
                        <x-share.cards.schema-card id="{{ $device->id }}" name="{{ $device->name }}"
                            category="{{ $device->category->name }}"></x-share.cards.schema-card>
                    </div>
                @endif
            @endforeach

            @foreach ($devices as $device)
            @if ($device->category->name == 'Transcoder')
                <div class="">
                    <x-share.arrows.left-arrow></x-share.arrows.left-arrow>
                </div>
                <div class="">
                    <x-share.cards.schema-card id="{{ $device->id }}" name="{{ $device->name }}"
                        category="{{ $device->category->name }}"></x-share.cards.schema-card>
                </div>
            @endif
        @endforeach
        </div>
    </div>
</x-share.cards.base-card>
