<x-mail::message>
    <b> Byli jste přidáni k události {{ $event->start_date }}.</b><br>
    <br>
    {{ $event->label }}: <br>
    <br>
    {!! $event->description !!}

</x-mail::message>
