<!-- @author John Sebastian Sebastian -->
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-2xl text-black">
            {{ __('Création Animateur') }}
        </h1>
    </x-slot>
    <x-form-Animateur.form-creer-animateur :animateur="$animateur"/>
    <x-footer/>
</x-app-layout>


