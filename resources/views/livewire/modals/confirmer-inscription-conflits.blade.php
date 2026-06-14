<div x-cloak x-data="{ open: false }" class="inline-block">
    <button x-on:click="open = ! open" class="modal-confirm" type="button">
        S'inscrire malgré le(s) conflit(s) d'horaire
    </button>
    <div
        x-show.transition.origin.top.right.duration.500ms="open"
        class="modal fade fixed top-0 left-0 right-0 bottom-0
        flex items-center w-full h-full p-4 bg-gray-100/50 overflow-y-auto transition duration-150 ease-in-out"
        id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="max-w-lg w-full m-auto p-8 bg-white border rounded-lg">
            <h3 class="mb-2 text-xl font-semibold text-coolGray-900">S'inscrire malgré le(s) conflit(s) d'horaire</h3>
            <div class="mt-4 mb-3 font-medium text-sm text-coolGray-500">
                <p>Voulez-vous vous inscrire à <strong>« {{$atelier->Nom}} »</strong>
                    @if($atelier->getListeAnimateurs())
                        par {{$atelier->getListeAnimateurs()}}
                    @endif
                le {{$atelier->getDateAsDateString()}} à {{$atelier->HeureDebut}} ({{$atelier->campus->Nom}})
                malgré le(s) conflit(s) d'horaire &nbsp;?</p>

                <h4 class="font-extrabold mt-4 mb-2 ml-4">Liste des conflits</h4>
                <ul class="list-disc ml-8 mb-4">
                    @foreach($atelier->getConflits($user) as $conflit)
                        <li>« {{$conflit->Nom}} »
                            @if($conflit->annule)
                                <em>(annulé)</em>
                            @elseif($conflit->pivot->attente == 1)
                                <em>(liste d'attente)</em>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <em>N'oubliez pas qu'en vous inscrivant vous vous engagez à être présent.e.
                    Vous pouvez au besoin vous désinscrire à partir du tableau de bord et/ou de la liste d'ateliers.</em>
            </div>
            <div class="flex flex-wrap justify-end mt-4">
                <div class="w-full md:w-1/2">
                    <button x-on:click="open = false"
                            class="modal-cancel !ml-0" type="button">
                        Annuler
                    </button>
                </div>
                <div class="w-full md:w-1/2">
                    <button type="submit" x-on:click="open = false"
                            class="modal-confirm">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

