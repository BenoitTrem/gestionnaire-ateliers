<!-- @author Benoit Tremblay -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-betweenw-full">
            <div class="flex items-center justify-between w-full flex-wrap gap-5 mr-20">

                <h1 class="font-bold text-2xl text-black">
                    {{ __('Ateliers') }}
                </h1>


                <form method="GET" action="{{ route('ateliers.index') }}" class=" flex flex-wrap items-end gap-4">
                    <div class="flex flex-col">
                        <input type="date" name="date" id="date" value="{{ request('date') }}" class="text-input" placeholder="Date"
                               min="{{ \Carbon\Carbon::parse(config('app.edition.debut_semaine'))->isoFormat('YYYY-MM-DD') }}"
                               max="{{ \Carbon\Carbon::parse(config('app.edition.fin_semaine'))->isoFormat('YYYY-MM-DD') }}">

                    </div>
                    <div class="flex flex-col">
                        <select name="campus_id" id="campus_id"
                                class="text-input pasDeFleche ">
                            <option value="">-- Tous les campus --</option>
                            @foreach ($liste_campus as $campus)
                                <option value="{{ $campus->id }}" {{ request('campus') == $campus->id ? 'selected' : '' }}>
                                    {{ $campus->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <input type="text" name="nom" id="nom" value="{{ request('nom') }}" class="text-input" placeholder="Nom de l'atelier">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btnFiltrer">
                            Filtrer
                        </button>
                        <a href="{{ route('ateliers.index') }}" class="btnFiltrer">
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
                             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-2 rounded relative" role="alert">
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
        <div class="absolute"></div>
        <div class="relative z-10 px-8 py-12">
        @if(session('atelier_creer'))
            <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="p-6 form-profil_2">
                    <h3 class="text-xl font-medium text-gray-900">
                        L'atelier "<span class="font-bold">{{ session('nom_atelier') }}</span>" a été créé avec succès !
                    </h3>
                    <div class="flex justify-center">
                        <button @click="open = false" class="mt-4 w-full max-w-[150px] button-modal">Fermer</button>
                    </div>
                </div>
            </div>
        @endif
            @if(session('atelier_ajout_route'))
                <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="p-6 form-profil_2">
                        <h3 class="text-xl font-medium text-gray-900">
                            L'animateur "<span class="font-bold">{{ session('nom_animateur') }}</span>" a été lié à l'atelier "<span class="font-bold">{{ session('nom_atelier') }}</span>" via Route/Url !
                        </h3>
                        <div class="flex justify-center">
                            <button @click="open = false" class="mt-4 w-full max-w-[150px] button-modal">Fermer</button>
                        </div>
                    </div>
                </div>
            @endif
        @if(session('atelier_modifier'))
            <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="p-6 form-profil_2">
                    <h3 class="text-xl font-medium text-gray-900">
                        L'atelier "<span class="font-bold">{{ session('nom_atelier') }}</span>" a été modifier avec succès !
                    </h3>
                    <div class="flex justify-center">
                        <button @click="open = false" class="mt-4 w-full max-w-[150px] max-h-[70px] button-modal">Fermer</button>
                    </div>
                </div>
            </div>
        @endif
        <div x-data="{ open: true }" x-show="open" x-transition:enter="transition-opacity duration-500" x-transition:leave="transition-opacity duration-500 opacity-0" x-init="setTimeout(() => open = false, 5000)" x-cloak>
            @if(session('atelier_supprime'))
                <div class="fixed bottom-0 right-0 m-4 supprimer-container z-50 mb-14 mr-28">
                    <span class="text-sm font-medium">{{ session('atelier_supprime') }}</span>
                </div>
            @endif
        </div>
        <div x-data="{ open: true }" x-show="open" x-transition:enter="transition-opacity duration-500" x-transition:leave="transition-opacity duration-500 opacity-0" x-init="setTimeout(() => open = false, 5000)" x-cloak>
            @if(session('erreur_courriel'))
                <div class="fixed bottom-0 right-0 m-4 supprimer-container z-50 mb-14 mr-28">
                    <span class="text-sm font-medium">{{ session('erreur_courriel') }}</span>
                </div>
            @endif
        </div>

            @canAny(['organisateur', 'estAdmin'])
                @php
                    $localDisponible = \App\Models\Local::where('disponibilite', true)->count();
                @endphp
                    @if ($localDisponible > 0)
                        <a href="{{ route('ateliers.create') }}" class="btn-ajouter ml-24">
                            <span class="plus">+</span>
                            <span class="text text-white">Ajouter un atelier</span>
                        </a>
                    @else
                        <div x-data="{ open: false }">
                            <button @click="open = true" class="btn-ajouter ml-24">
                                <span class="plus">+</span>
                                <span class="text text-white">Ajouter un atelier</span>
                            </button>
                            <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" x-cloak>
                                <div class="p-6 form-profil_2">
                                    <h2 class="text-lg font-medium text-gray-900">Aucun local disponible</h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Il n'y a actuellement aucun local disponible. Voulez voulez quand même créer un atelier?
                                    </p>
                                    <div class="flex justify-end space-x-4 mt-4">
                                        <button @click="open = false" class="primary-button_2 w-full max-w-[120px]">
                                            Fermer
                                        </button>
                                        <a href="{{ route('ateliers.create') }}" class="primary-button_2">
                                            Créer un atelier
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan


            <div class="atelier-container  min-w-[900px]">
            <ul class="grid divide-y divide-neutral-200 mx-auto">
                @if($ateliers->count() < 1)
                    <li class="text-red-700 px-4 py-3 my-2 rounded relative text-center">Aucun atelier trouvé. Veuillez
                        modifier vos critères de recherche.
                    </li>
                @else
                    @foreach( $ateliers as $atelier)
                        <li class="py-8">
                            <details class="group bg-white shadow-md rounded-lg overflow-hidden transition duration-300 hover:shadow-lg">
                                <summary class="flex justify-between items-center p-4 font-semibold cursor-pointer list-none bg-gray-100 group-open:bg-gray-200 transition">
                                    <div class="flex items-center gap-3">
                                        <h2 class="text-lg">{{ $atelier->nom }}
                                            @if($atelier->animateur_id)
                                                <span class="text-gray-600 text-sm">( {{ $atelier->animateur_id }} )</span>
                                            @endif
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
                                    <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-600">{{ $atelier->description }}</p>
                                    <h3 class="font-semibold text-gray-900 mt-3">Animateur(s)</h3>
                                        <ul class="list-disc pl-5 space-y-1 text-gray-600">
                                            <div x-data="{
                                                isOpen: false,
                                                prenom: '',
                                                nom: '',
                                                biographie: '',
                                                expertise: '',
                                                openAnimateur(prenom, nom, biographie, expertise, email) {
                                                    this.prenom = prenom;
                                                    this.nom = nom;
                                                    this.biographie = biographie && biographie.trim() !== '' ? biographie : 'Aucune biographie disponible.';
                                                    this.expertise = expertise && expertise.trim() !== '' ? expertise : ' Aucune expertise disponible.';
                                                    this.isOpen = true;
                                                },
                                                close() {
                                                    this.isOpen = false;
                                                }
                                            }">
                                            <ul>
                                                @forelse($atelier->animateurs as $animateur)
                                                    <li>
                                                        <button
                                                            @click="openAnimateur('{{ addslashes($animateur->prenom) }}', '{{ addslashes($animateur->nom) }}', '{{ addslashes($animateur->biographie) }}', '{{ addslashes($animateur->expertise) }}', '{{ addslashes($animateur->email) }}')"
                                                            class="text-blue-600 underline hover:text-blue-800 cursor-pointer">
                                                            {{ $animateur->prenom }} {{ $animateur->nom }}
                                                        </button>
                                                    </li>
                                                @empty
                                                    <li>Aucun animateur assigné</li>
                                                @endforelse
                                            </ul>
                                            <div
                                                x-show="isOpen"
                                                style="display: none;"
                                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                                @keydown.escape.window="close()"
                                                @click.self="close()">
                                                <div class=" form-profil bg-white rounded-lg p-6 max-w-lg w-full relative">
                                                    <h2 class="text-2xl text-black font-bold mb-2" x-text="prenom + ' ' + nom"></h2>
                                                    <p class="mb-2"><strong>Biographie :</strong> <span x-text="biographie"></span></p>
                                                    <p class="mb-2"><strong>Expertise :</strong> <span x-text="expertise"></span></p>
                                                    <div class="flex justify-center mt-6">
                                                        <button @click="close()" class="button-modal max-w-[120px]">Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </ul>
                                    <h3 class="font-semibold text-gray-900 mt-3">Détails</h3>
                                    <ul class="list-disc pl-5 space-y-1 text-gray-600">
                                        <li><strong>Durée :</strong> {{ $atelier->duree_minutes }} minutes</li>
                                        @if($atelier->date)
                                            <li><strong>Date :</strong> {{ \Carbon\Carbon::parse($atelier->date)->format('d M Y') }} à {{ $atelier->heure_debut }}</li>
                                        @endif
                                        <li><strong>Campus :</strong> {{ $atelier->campus->nom ?? 'N/A' }}</li>

                                        <li><strong>Local :</strong> {{ optional($atelier->local)->numeroLocal ?? 'N/A' }}</li>

                                        <li><strong>Capacité :</strong>
                                            {{ optional($atelier->local)->capacite ? $atelier->local->capacite . ' places disponibles' : 'N/A' }}
                                        </li>

                                        <li><strong>Lien d'inscription :</strong>
                                            @if(!empty($atelier->url_inscription))
                                                <a href="{{ $atelier->url_inscription }}" target="_blank" rel="noreferrer noopener"
                                                   class="text-blue-600 hover:underline">
                                                    {{ $atelier->url_inscription }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </li>
                                    </ul>
                                    <div x-data="{ open: false }">
                                        <div class="flex justify-end space-x-4 mt-4">
                                            @canAny(['organisateur', 'estAdmin'])
                                            <a href="{{ route('ateliers.edit', $atelier->id) }}" class="button-modifier">
                                                Modifier
                                            </a>
                                            @endcanany
                                            @can('organisateur')
                                            <button @click="open = true" class="button-sup">
                                                Supprimer
                                            </button>
                                            @endcan
                                                @can('utilisateur')
                                                    <div x-data="{ isOpen: false }">
                                                        <button href="#" @click.prevent="isOpen = true" class="button-modifier">
                                                            S'inscrire
                                                        </button>
                                                        <div
                                                            x-show="isOpen"
                                                            style="display: none;"
                                                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                                            @keydown.escape.window="isOpen = false"
                                                            @click.self="isOpen = false">
                                                            <div class="form-profil">
                                                                <h2 class="text-xl font-semibold mb-4">Inscription réussie</h2>
                                                                <p>Vous êtes bien inscrit(e) à cet atelier.</p>
                                                                <div class="mt-4 text-right">
                                                                    <button @click="isOpen = false" class="button-modal px-4 py-2">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan
                                        </div>
                                        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" x-cloak>
                                            <div class="p-6 form-profil_2">
                                                <h2 class="text-lg font-medium text-gray-900">Confirmer la suppression</h2>
                                                <p class="mt-1 text-sm text-gray-600">Voulez-vous vraiment supprimer cet atelier ?</p>
                                                <div class="flex justify-end space-x-4 mt-4">
                                                    <button @click="open = false" class="primary-button_2 w-full max-w-[120px]">
                                                        Annuler
                                                    </button>
                                                    <form action="{{ route('ateliers.destroy', $atelier->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="secondary-button">
                                                            Confirmer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </details>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        </div>
        @if($ateliers->hasPages())
            <div class="flex-col md:flex-row items-center">
                <div class="w-full md:w-auto flex justify-center">
                    {{ $ateliers->links() }}
                </div>
            </div>
            <p class="p-4"></p>
        @endif
        <p class="p-28"></p>
    </section>
    <x-footer />
</x-app-layout>
</html>
