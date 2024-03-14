<x-mail::message>
    <b> Vítejte v IPTV dokumentaci.</b><br>
    <br>
    Vaše přístupové údaje jsou: <br>
    <br>
    <b>{{ $email }}</b> <br>
    <b>{{ $password }}</b> <br>
    <x-mail::button :url="Config::get('app.url')">
        Přihlásit se
    </x-mail::button>

</x-mail::message>
