<!-- @author Benoit Tremblay -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Locaux</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between w-full">
            <h1 class="font-bold text-2xl text-black">
                {{ __('Locaux') }}
            </h1>

            <div class="flex-1 flex justify-center">
                <form method="GET" action="{{ route('locaux.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex flex-col">
                        <select name="campus_id" id="campus_id" class="text-input pasDeFleche ">
                            <option value="">-- Tous les campus --</option>
                            @foreach ($liste_campus as $campus)
                                <option value="{{ $campus->id }}" {{ request('campus_id') == $campus->id ? 'selected' : '' }}>
                                    {{ $campus->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <select name="disponibilite" id="disponibilite" class="inputFiltrer">
                            <option value="1" {{ request('disponibilite', '1') === '1' ? 'selected' : '' }}>Disponible</option>
                            <option value="0" {{ request('disponibilite') === '0' ? 'selected' : '' }}>Indisponible</option>
                        </select>

                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="btnFiltrer">
                            Filtrer
                        </button>
                        <a href="{{ route('locaux.index') }}" class="btnFiltrer">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>



    </x-slot>

    <section class="min-h-screen bg-image relative">
        <div class="absolute"></div>
        <div class="relative z-10 px-8 py-12">
            @if(session('local_creer'))
                <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="p-6 form-profil_2">
                        <h3 class="text-xl font-medium text-gray-900">
                            Le local "<span class="font-bold">{{ session('numero_local') }}</span>" a été créé avec succès !
                        </h3>
                        <div class="flex justify-center">
                            <button @click="open = false" class="mt-4 w-full max-w-[150px] button-modal">Fermer</button>
                        </div>
                    </div>
                </div>
            @endif
            @if(session('local_modifier'))
                <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="p-6 form-profil_2">
                        <h3 class="text-xl font-medium text-gray-900">
                            Le local "<span class="font-bold">{{ session('numero_local') }}</span>" a été modifier avec succès !
                        </h3>
                        <div class="flex justify-center">
                            <button @click="open = false" class="mt-4 w-full max-w-[150px] max-h-[70px] button-modal">Fermer</button>
                        </div>
                    </div>
                </div>
            @endif
            <div x-data="{ open: true }" x-show="open" x-transition:enter="transition-opacity duration-500" x-transition:leave="transition-opacity duration-500 opacity-0" x-init="setTimeout(() => open = false, 5000)" x-cloak>
                @if(session('local_supprime'))
                    <div class="fixed bottom-0 right-0 m-4 supprimer-container z-50 mb-14 mr-28">
                        <span class="text-sm font-medium">{{ session('local_supprime') }}</span>
                    </div>
                @endif
            </div>
            @canAny(['organisateur', 'estAdmin'])
                <a href="{{ route('locaux.create') }}" class="btn-ajouter ml-24">
                    <span class="plus">+</span>
                    <span class="text text-white">Ajouter un local</span>
                </a>
            @endcan
            <div class="local-container min-w-[900px]">
                <ul class="grid divide-y divide-neutral-200 mx-auto">
                    @if($locaux->isEmpty())
                        <li class="text-red-700 px-4 py-3 my-2 rounded relative text-center">
                            Aucun local trouvé. Veuillez en ajouter un.
                        </li>
                    @else
                        @foreach($locaux as $local)
                            <li class="py-8">
                                <details class="group bg-white shadow-md rounded-lg overflow-hidden transition duration-300 hover:shadow-lg">
                                    <summary class="flex justify-between items-center p-4 font-semibold cursor-pointer list-none bg-gray-100 group-open:bg-gray-200 transition">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 flex items-center justify-center rounded-full text-white font-bold text-lg"
                                                 style="background: {{ $local->disponibilite ? '#16a34a' : '#dc2626' }};">
                                            {{ strlen($local->numeroLocal) > 4 ? substr($local->numeroLocal, 0, 4) : $local->numeroLocal }}
                                            </div>
                                            <h2 class="text-lg">
                                                Local {{ $local->numeroLocal }} (Capacité: {{ $local->capacite }})
                                            </h2>
                                            <span class="py-1 px-3 rounded-full text-sm font-medium
                                                   {{ $local->disponibilite ? 'animateur-disponible' : 'animateur-indisponible' }}">
                                                   {{ $local->disponibilite ? 'Disponible' : 'Indisponible' }}
                                            </span>
                                        </div>
                                        <span class="transition-transform transform group-open:rotate-180">
                                        <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                             stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </span>
                                    </summary>
                                    <div class="text-neutral-700 p-5 bg-white border-t border-gray-200 group-open:animate-fadeIn">
                                        <h3 class="font-semibold text-gray-900 mb-2">Détails du local</h3>
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li><strong>Local :</strong> {{ $local->numeroLocal }}</li>
                                            <li><strong>Campus :</strong> {{ $local->campus->nom }}</li>
                                            <li><strong>Capacité :</strong> {{ $local->capacite }} personnes</li>
                                            <li><strong>Disponiblite :</strong>
                                                @if($local->disponibilite)
                                                    Oui
                                                @elseif(!$local->disponibilite)
                                                Non
                                                @endif
                                            </li>
                                        </ul>
                                        @canAny(['organisateur', 'estAdmin'])
                                            <div x-data="{ open: false, cannotDelete: {{ $local->ateliers()->exists() ? 'true' : 'false' }} }">
                                                <div class="flex justify-end space-x-4 mt-4">
                                                    <a href="{{ route('locaux.edit', $local->id) }}" class="button-modifier">
                                                        Modifier
                                                    </a>
                                                    @can('organisateur')
                                                    <button @click="open = true" class="button-sup">
                                                        Supprimer
                                                    </button>
                                                    @endcan
                                                </div>
                                                <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" x-cloak>
                                                    <div class="p-6 form-profil_2">
                                                        <h2 class="text-lg font-medium text-gray-900" x-text="cannotDelete ?
                                                        'Attention ! Local utilisé pour un atelier' : 'Confirmer la suppression'"></h2>
                                                        <p
                                                            class="mt-1 text-sm"
                                                            :class="cannotDelete ? 'text-red-600' : 'text-gray-600'"
                                                            x-text="cannotDelete
                                                                ? 'Ce local est utilisé pour un atelier. Supprimer ce local peut avoir des conséquences.'
                                                                : 'Voulez-vous vraiment supprimer ce local ?'"
                                                        ></p>

                                                        <div class="flex justify-end space-x-4 mt-4">
                                                            <button @click="open = false" class="primary-button_2 w-full max-w-[120px]">
                                                                Annuler
                                                            </button>
                                                            <form action="{{ route('locaux.destroy', $local->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="secondary-button bg-red-600 hover:bg-red-700 text-white">
                                                                    <span x-text="cannotDelete ? 'Supprimer quand même' : 'Confirmer'"></span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endcan
                                    </div>
                                </details>
                            </li>

                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        @if($locaux->hasPages())
            <div class="flex-col md:flex-row items-center">
                <div class="w-full md:w-auto flex justify-center">
                    {{ $locaux->links() }}
                </div>
            </div>
            <p class="p-4"></p>
        @endif
        <p class="p-28"></p>
    </section>
    <x-footer />
</x-app-layout>
