<!-- @author Benoit Tremblay -->

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-2xl text-black">
            {{ __('Création Atelier') }}
        </h1>
    </x-slot>
    @canAny(['organisateur', 'estAdmin'])
        <x-form-atelier.form-creer-atelier :campuses="$campuses" :atelier="$ateliers"  :animateurs="$animateurs" :locals="$locals" />
    @else
        <div class="text-red-600 font-semibold mt-4">
            {{ __('Vous n\'êtes pas autorisé à créer un atelier.') }}
        </div>
    @endcan
    <x-footer/>

</x-app-layout>
