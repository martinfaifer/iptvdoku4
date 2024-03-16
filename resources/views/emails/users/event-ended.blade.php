<x-mail::message>
    <b> Události {{ $event->label }} byla ukončena.</b><br>
    @endif <br>
    <br>
    {!! $event->description !!}

</x-mail::message>
