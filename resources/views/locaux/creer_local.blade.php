<!-- @author Benoit Tremblay -->
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-2xl text-black">
            {{ __('Création Local') }}
        </h1>
    </x-slot>
    @canAny(['organisateur', 'estAdmin'])
        <x-form-local.form-creer-local :campuses="$campuses" />
    @else
        <div class="text-red-600 font-semibold mt-4">
            {{ __('Vous n\'êtes pas autorisé à créer un local.') }}
        </div>
    @endcan
    <x-footer/>
</x-app-layout>


