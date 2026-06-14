<!-- @author John Sebastian Sebastian -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Animateurs</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-betweenw-full">
            <div class="flex items-center justify-between w-full flex-wrap gap-5 mr-20">
                <h1 class="font-bold text-2xl text-black">
                    {{ __('Animateurs') }}
                </h1>

                <form method="GET" action="{{ route('animateurs.index') }}" class=" flex flex-wrap items-end gap-4">


                    <div class="flex flex-col">
                        <input type="text" name="nom" id="nom" value="{{ request('nom') }}" class="text-input"
                               placeholder="Nom de l'animateur">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btnFiltrer">
                            Filtrer
                        </button>
                        <a href="{{ route('animateurs.index') }}" class="btnFiltrer">
                            Réinitialiser
                        </a>
                    </div>
                </form>

                <div x-data="{ open: true }">
                    @if (session()->has('message'))
                    <div x-show.transition.origin.top.right.duration.500ms="open"
                         class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-2 rounded relative"
                         role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" x-on:click="open = false">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20"><title>Close</title>
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>
                    @endif
                    @if (session()->has('erreur'))
                    <div x-show.transition.origin.top.right.duration.500ms="open"
                         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-2 rounded relative"
                         role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" x-on:click="open = false">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20"><title>Close</title>
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                            </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
    <section class="min-h-screen bg-image relative">
        <div class="relative z-10 px-8 py-12">
            @if(session('animateur_creer'))
                <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="p-6 form-profil_2">
                        <h3 class="text-xl font-medium text-gray-900">
                            L'animateur "<span class="font-bold">{{ session('nom_animateur') }}</span>" a été ajouté avec succès !
                        </h3>
                        <div class="flex justify-center">
                            <button @click="open = false" class="mt-4 w-full max-w-[150px] button-modal">Fermer</button>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('animateur_modifier'))
                <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="p-6 form-profil_2">
                        <h3 class="text-xl font-medium text-gray-900">
                            L'animateur "<span class="font-bold">{{ session('prenom_animateur') }} {{ session('nom_animateur') }}</span>" a été modifié avec succès !
                        </h3>
                        <div class="flex justify-center">
                            <button @click="open = false" class="mt-4 w-full max-w-[150px] button-modal">Fermer</button>
                        </div>
                    </div>
                </div>
            @endif
                @if(session('animateur_supprime'))
                    <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="p-6 form-profil_2">
                            <h3 class="text-xl font-medium text-gray-900">
                                {{ session('animateur_supprime') }}
                            </h3>
                            <div class="flex justify-center">
                                <button @click="open = false" class="mt-4 w-full max-w-[150px] button-modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                @endif

            @canAny(['organisateur', 'estAdmin'])
                <a href="{{ route('animateurs.create') }}" class="btn-ajouter ml-24">
                    <span class="plus">+</span>
                    <span class="text text-white-50  font-weight-bolder">Ajouter un animateur</span>
                </a>
            @endcan

            <div class="animateur-container min-w-[900px]">
                <ul class="grid divide-y divide-neutral-200 mx-auto">
                    @if($animateurs->isEmpty())
                        <li class="text-red-700 px-4 py-3 my-2 rounded relative text-center">
                            Aucun animateur trouvé. Veuillez
                            modifier vos critères de recherche.
                        </li>
                    @else
                        @foreach($animateurs as $animateur)
                            <li class="py-8">
                                <details class="group bg-white shadow-md rounded-lg overflow-hidden transition duration-300 hover:shadow-lg">
                                    <summary class="flex justify-between items-center p-4 font-semibold cursor-pointer list-none bg-gray-100 group-open:bg-gray-200 transition">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 flex items-center justify-center rounded-full text-black font-weight-bolder text-lg
                                             bg-gray-400 ">
                                                {{ strtoupper(substr($animateur->prenom, 0, 1)) }}{{ strtoupper(substr($animateur->nom, 0, 1)) }}
                                            </div>
                                            <h2 class="text-lg">
                                                {{ $animateur->prenom }} {{ $animateur->nom }}
                                            </h2>
                                        </div>
                                        <span class="transition-transform transform group-open:rotate-180">
                                            <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                 stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                                <path d="M6 9l6 6 6-6"></path>
                                            </svg>
                                        </span>
                                    </summary>

                                    <div class="text-neutral-700 p-5 bg-white border-t border-gray-200 group-open:animate-fadeIn">
                                        <h3 class="font-semibold text-gray-900 mb-2">Détails de l'animateur</h3>
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li><strong>Nom :</strong> {{ $animateur->prenom }} {{ $animateur->nom }}</li>
                                            <li><strong>Email :</strong> {{ $animateur->email }}</li>
                                            <li><strong>Expertise :</strong> {{ $animateur->expertise }}</li>
                                        </ul>

                                        @canAny(['organisateur', 'estAdmin'])
                                            <div x-data="{ open: false, hasAteliers: {{ $animateur->ateliers->count() > 0 ? 'true' : 'false' }} }">
                                                <div class="flex justify-end space-x-4 mt-4">
                                                    <a href="{{ route('animateurs.edit', $animateur->id) }}" class="button-modifier">
                                                        Modifier
                                                    </a>
                                                    @can('organisateur')
                                                        <button @click="open = true" class="button-sup">
                                                            Supprimer
                                                        </button>
                                                    @endcan
                                                </div>


                                                <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" x-cloak>
                                                    <div class="p-6 bg-white rounded form-profil_2">
                                                        <h2 class="text-lg font-medium text-gray-900">Confirmer la suppression</h2>
                                                        <template x-if="hasAteliers">
                                                            <p class="mt-1 text-sm text-red-600">
                                                                Attention : cet animateur est lié à un ou plusieurs ateliers. Ils seront désassociés lors de la suppression.
                                                            </p>
                                                        </template>
                                                        <template x-if="!hasAteliers">
                                                            <p class="mt-1 text-sm text-gray-600">
                                                                Voulez-vous vraiment supprimer cet animateur ?
                                                            </p>
                                                        </template>

                                                        <div class="flex justify-end space-x-4 mt-4">
                                                            <button @click="open = false" class="primary-button_2 w-full max-w-[120px]">Annuler</button>

                                                            <form action="{{ route('animateurs.destroy', $animateur->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="secondary-button">Confirmer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    @endcan
                                </details>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        @if($animateurs->hasPages())
            <div class="flex justify-center mt-4">
                {{ $animateurs->links() }}
            </div>
        @endif
        <p class="p-28"></p>
    </section>
    <x-footer />
</x-app-layout>
