<x-mail::message>
    <b> Nové heslo</b><br>
    <br>
    Na Vaši žádost bylo vygenerováno nové heslo: <br>
    <br>
    <b>{{ $new_password }}</b> <br>
    <x-mail::button :url="Config::get('app.url')">
        Přihlásit se
    </x-mail::button>

</x-mail::message>
