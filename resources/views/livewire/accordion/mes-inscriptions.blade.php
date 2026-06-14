<section class="-mx-4">
    <div class="px-4 mx-auto">
        <div x-data="{ open: true }">
            @if (session()->has('message'))
                <div x-show.transition.origin.top.right.duration.500ms="open" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-2 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" x-on:click="open = false">
                        <svg class="fill-current h-6 w-6 text-greem-500" role="button" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20"><title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                </div>
            @endif
            @if (session()->has('erreur'))
                <div  x-show.transition.origin.top.right.duration.500ms="open" class="bg-reg-100 border border-reg-400 text-red-700 px-4 py-3 my-2 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" x-on:click="open = false">
                        <svg class="fill-current h-6 w-6 text-greem-500" role="button" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20"><title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                </div>
            @endif
        </div>
        <div class="max-w-screen-xl mx-auto px-5 bg-white min-h-sceen border rounded-md">
            <ul class="grid divide-y divide-neutral-200 mx-auto">
                @if($ateliers->count()<1)
                    <li class="bg-reg-100 text-red-700 px-4 py-3 my-2 rounded relative">Aucun atelier trouvé. Veuillez modifier vos critères de recherche.</li>
                @else
                    @foreach($ateliers as $atelier)
                        <li class="py-5">
                            <details class="group">
                                <summary class="flex justify-between items-center font-medium cursor-pointer list-none">
                                    <h3 class="h5">{{$atelier->Nom}} - {{$atelier->getListeAnimateurs()}}
                                        @if($atelier->annule)
                                            <span class="py-1 px-2 ml-2 no-underline rounded-full bg-red-800 text-white font-semibold text-sm border-red-800">Annulé</span>
                                        @endif
                                        @if($user->ateliers_attente->contains($atelier->id))
                                            <span class="py-1 px-2 ml-2 no-underline rounded-full bg-yellow-800 text-white font-semibold text-sm border-yellow-800">En attente</span>
                                        @elseif(!$atelier->annule &&
                                                $user->ateliers->filter(function ($value, $key) use ($atelier) {
                                                    return $value->id != $atelier->id;
                                                })
                                                ->contains(function ($value, $key) use ($atelier){
                                                    $date_atelier = \Carbon\CarbonImmutable::create($atelier->DateAtelier);
                                                    $debut_atelier = \Carbon\CarbonImmutable::parse($date_atelier->format('Y-m-d').' '.$atelier->HeureDebut);
                                                    $fin_atelier = $debut_atelier->addMinutes(intval($atelier->Duree));
                                                    $date_value = \Carbon\CarbonImmutable::create($value->DateAtelier);
                                                    $debut_value = \Carbon\CarbonImmutable::parse($date_value->format('Y-m-d').' '.$value->HeureDebut);
                                                    $fin_value = $debut_value->addMinutes(intval($value->Duree));

                                                    return ($debut_atelier->greaterThanOrEqualTo($debut_value) && $debut_atelier->lessThan($fin_value))
                                                    || ($fin_atelier->greaterThan($debut_value) && $fin_atelier->lessThanOrEqualTo($fin_value))
                                                    || ($debut_value->greaterThanOrEqualTo($debut_atelier) && $fin_value->lessThanOrEqualTo($fin_atelier))
                                                    || ($debut_atelier->greaterThanOrEqualTo($debut_value) && $fin_atelier->lessThanOrEqualTo($fin_value));
                                                }))
                                            <span class="py-1 px-2 ml-2 no-underline rounded-full bg-amber-800 text-white font-semibold text-sm border-amber-800 whitespace-nowrap">Conflit d'horaire</span>
                                        @endif
                                    </h3>
                                    <span class="transition group-open:rotate-180">
                             <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                                </summary>
                                <div class="text-neutral-600 mt-3 p-4 bg-gray-50 group-open:animate-fadeIn">
                                    <h4 class="font-semibold">Description</h4>
                                    <p>{{$atelier->Description}}</p>
                                    <h4 class="font-semibold mt-3">Animateur(s)</h4>
                                    <ul class="list-disc mb-3 pl-8">
                                        @foreach($atelier->animateurs as $animateur)
                                            <li>
                                                @livewire('modals.modal-info-animateur', ['animateur' => $animateur], key('show-'.$atelier->id.'-'.$animateur->id))
                                            </li>
                                        @endforeach
                                    </ul>
                                    <h4 class="font-semibold mt-3">Détails</h4>
                                    <ul class="list-disc mb-3 pl-8">
                                        <li>Durée (min): {{$atelier->Duree}}</li>
                                        <li>{{$atelier->getDateAsDateString()}} à {{$atelier->HeureDebut}}</li>
                                        @if($atelier->Endroit)
                                            <li>{{$atelier->Endroit}} ({{$atelier->campus->Nom}})</li>
                                        @else
                                            <li>Campus: {{$atelier->campus->Nom}}</li>
                                        @endif
                                        <li>Participants: {{$atelier->getNbParticipants() ? :0}}/{{$atelier->NombreDePlace}}</li>
                                        @if(isset($atelier->url))
                                            <li>Lien pour joindre l'atelier:<a href="{{$atelier->url}}" target="_blank" rel="noreferrer noopener" class="mt-1 mr-1 px-2 text-blue-800 dark:text-blue-500 hover:underline long-link">{{$atelier->url}}</a></li>
                                        @endif
                                    </ul>
                                    <div class="align-middle flex">
                                        {{-- Désinscription si pas dans le passé --}}
                                        @if(Carbon\Carbon::create($atelier->DateAtelier)->addHours($atelier->HeureDebut) >= \Carbon\Carbon::now())
                                            <form method="post" id="submit-button"
                                                  action="{{ route('atelier-annuler-inscription', [$atelier->id, Auth::id()])}}"
                                                  class="inline-flex">
                                                @csrf
                                                @livewire('modals.confirmer-modal',
                                                [
                                                'titre' => "Annuler l'inscription",
                                                'message' => "Voulez-vous vous annuler votre inscription à «
                                                $atelier->Nom » par {$atelier->getListeAnimateurs()} le
                                                {$atelier->getDateAsDateString()} à $atelier->HeureDebut (
                                                {$atelier->campus->Nom} )".html_entity_decode("&nbsp;")."?"
                                                ],
                                                key('confirmer-annuler'.$atelier->id))
                                            </form>
                                        @endif
                                        @if($atelier->Endroit||$atelier->url)
                                            <div class="pl-2 inline-flex md:ml-2">
                                                <a href="{{$atelier->getCalLink()->ics()}}" class="calendar-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                         stroke-width="1.5" stroke="currentColor"
                                                         class="w-4 h-4 mr-2 align-middle">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                                    </svg>
                                                    Ajouter au calendrier (.ics)
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </details>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</section>
