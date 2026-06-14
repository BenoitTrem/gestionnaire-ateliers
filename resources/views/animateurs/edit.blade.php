<!-- @author John Sebastian Sebastian -->
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-2xl text-black">
            {{ __('Modification Animateur') }}
        </h1>
    </x-slot>
    <x-form-Animateur.form-modifier-animateur :animateur="$animateur" />
    <x-footer />
</x-app-layout>


