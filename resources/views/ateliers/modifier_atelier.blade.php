<!-- @author Benoit Tremblay -->
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-2xl text-black">
            {{ __('Modification d\'atelier') }}
        </h1>
    </x-slot>
    @canAny(['organisateur', 'estAdmin'])
        <x-form-atelier.form-modifier-atelier :campuses="$campus" :atelier="$atelier" :animateurs="$animateurs" :locals="$locals" ></x-form-atelier.form-modifier-atelier>
    @else
        <div class="text-red-600 font-semibold mt-4">
            {{ __('Vous n\'êtes pas autorisé à modifier un atelier.') }}
        </div>
    @endcan
    <x-footer />
</x-app-layout>
