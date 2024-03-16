<x-mail::message>
    <b> Události {{ $event->label }} započala.</b><br>
    @endif <br>
    <br>
    {!! $event->description !!}

</x-mail::message>
