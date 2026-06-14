<x-mail::message>
# Un nouvel atelier a été ajouté.

    Nom de l'atelier : {{ $atelier->nom }}
    {{--<x-mail::button :url="''">--}}
    {{--Button Text--}}
    {{--</x-mail::button>--}}
Merci,<br>
{{ config('app.name') }}
</x-mail::message>

