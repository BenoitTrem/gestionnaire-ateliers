<!-- @author Benoit Tremblay -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
        <h1 class="font-bold text-2xl text-black">
                {{ __('Horaire') }}
            </h1>
            <div class="flex items-center justify-center gap-3 w-full mr-20">
                <div class="flex items-center">
                    <select wire:model="campus" class="text-input" id="filtreCampus" name="filtreCampus">
                        <option value="">-- Tous les campus --</option>
                        @foreach ($liste_campus as $campus)
                            <option value="{{ $campus->id }}">{{ $campus->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </x-slot>

    <section class="min-h-screen bg-image relative flex items-center justify-center">
        <p class="space"></p>
        <div class="container-calendrier">
            <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css" rel="stylesheet">
            <div id="calendar" class="w-full"></div>
        </div>
    </section>


    <div id="atelierModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="p-6 form-profil_2 bg-white rounded-lg max-w-[600px] min-w-[600px]">
            <span id="atelierTitle" class="font-semibold text-2xl text-center block pb-5"></span>
            <div class="space-y-3">
                <p id="atelierDescription" class="text-gray-600 pb-2"></p>
                <ul id="atelierDetails" class="list-disc pl-5 space-y-1 text-gray-600 ">
                </ul>
            </div>

            <div class="flex justify-center space-x-4 mt-4">
                @canAny(['organisateur', 'estAdmin'])
                        <a id="boutonModifier" href="#" class="button-modifier">
                          Modifier
                        </a>
                @endcan
                    @can('utilisateur')
                        <div
                            x-data="{ isOpen: false }"
                            class="bottom-0 left-0 right-0 p-4 gap-8 flex justify-between items-center">
                            <button
                                @click.prevent="isOpen = true"
                                class="button-modifier min-w-[150px] text-center">
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
                                        <button @click="isOpen = false" class="button-modal px-4 py-2">
                                            Fermer
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button @click="open = false" id="closeModalButton" class="button-modal min-w-[150px]">
                                Fermer
                            </button>
                        </div>
                    @endcan

                @can('organisateur')
                       <button onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="button-sup">
                           Supprimer
                        </button>
                @endcan
            </div>
            <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
                <div class="p-6 form-profil_2">
                    <h2 class="text-lg font-medium text-gray-900">Confirmer la suppression</h2>
                    <p id="deleteWarning" class="mt-1 text-sm text-gray-600"></p>
                    <div class="flex justify-end space-x-4 mt-4">
                        <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="primary-button_2 w-full max-w-[120px]">
                            Annuler
                        </button>
                        <form id="Supprimer" action="#" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="secondary-button">
                                Confirmer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @canAny(['organisateur', 'estAdmin'])
                <div class=" flex justify-center">
                    <button @click="open = false" id="closeModalButton" class="mt-4 w-full max-w-[150px] button-modal">Fermer</button>
                </div>
            @endcan
        </div>

        <div id="animateurModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="p-6 form-profil_2 bg-white rounded-lg max-w-[500px] min-w-[400px]">
                <h2 id="animateurNom" class="font-semibold text-2xl mb-4"></h2>
                <p id="animateurBio"  class="text-gray-600mb-2"><strong>Biographie :</strong> </p>
                <p id="animateurExpertise" class="text-gray-600mb-2"><strong>Expertise :</strong> </p>
                <div class="flex justify-center mt-6">
                    <button id="closeAnimateurModal" class="button-modal max-w-[120px]">Fermer</button>
                </div>
            </div>
        </div>



    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/locale/fr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>

    @vite('resources/js/calendrier.js')

    <x-footer/>
</x-app-layout>
