<x-mail::message>
    <b> Byli jste přidáni k události {{ $event->label }} .</b><br>
    <br>
    Událost je plánována na {{ $event->start_date }} @if (!is_null($event->end_date))
        do {{ $event->end_date }}
    @endif <br>
    <br>
    {!! $event->description !!}

</x-mail::message>
