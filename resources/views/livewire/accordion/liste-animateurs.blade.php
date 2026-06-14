<section class="py-4">
    <div class="px-4 mx-auto">
        <div class="flex flex-wrap items-center justify-between -m-2 mb-4">
            <div class="w-full md:w-1/2 p-2 grow md:grow-0 flex flex-wrap items-center text-white text-2xl">
                <h2 contenteditable="false">{{ __('custom.Animateurs') }}</h2>
                @can('estAdmin')
                    <span class="ml-3" aria-label="button">
                        <a class="hover:bg-gray-800 rounded-md"
                           title="Ajouter une conférencière ou un conférencier"
                           href="{{route('animateurs.create')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                             stroke="currentColor" class=" w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        <span class="sr-only">Ajouter une conférencière ou un conférencier</span>
                    </a>
                </span>
                @endcan
            </div>
            <div class="w-full md:w-1/3 p-2 grow md:grow-0">
                <div class="relative px-6 bg-white rounded-3xl">
                    <svg class="absolute left-4 transform top-1/2 -translate-y-1/2" width="16" height="16"
                         viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.0467 11.22L12.6667 9.80667C12.3699 9.5245 11.9955 9.33754 11.5916 9.26983C11.1876 9.20211 10.7727 9.25673 10.4001 9.42667L9.80008 8.82667C10.5071 7.88194 10.83 6.70445 10.7038 5.53122C10.5775 4.358 10.0115 3.27615 9.1197 2.50347C8.22787 1.73078 7.07643 1.32464 5.89718 1.36679C4.71794 1.40894 3.59844 1.89626 2.76405 2.73065C1.92967 3.56503 1.44235 4.68453 1.4002 5.86378C1.35805 7.04302 1.76419 8.19446 2.53687 9.08629C3.30956 9.97812 4.3914 10.5441 5.56463 10.6704C6.73786 10.7966 7.91535 10.4737 8.86007 9.76667L9.45341 10.36C9.26347 10.7331 9.1954 11.1564 9.25879 11.5702C9.32218 11.984 9.51383 12.3675 9.80674 12.6667L11.2201 14.08C11.5951 14.4545 12.1034 14.6649 12.6334 14.6649C13.1634 14.6649 13.6717 14.4545 14.0467 14.08C14.2372 13.8937 14.3886 13.6713 14.4919 13.4257C14.5953 13.1802 14.6485 12.9164 14.6485 12.65C14.6485 12.3836 14.5953 12.1198 14.4919 11.8743C14.3886 11.6287 14.2372 11.4063 14.0467 11.22ZM8.39341 8.39333C7.9269 8.85866 7.33294 9.1753 6.68657 9.30323C6.0402 9.43117 5.37041 9.36466 4.76181 9.11212C4.15321 8.85958 3.63312 8.43234 3.26722 7.88436C2.90132 7.33638 2.70603 6.69224 2.70603 6.03333C2.70603 5.37442 2.90132 4.73029 3.26722 4.18231C3.63312 3.63433 4.15321 3.20708 4.76181 2.95454C5.37041 2.702 6.0402 2.6355 6.68657 2.76343C7.33294 2.89137 7.9269 3.208 8.39341 3.67333C8.70383 3.98297 8.95012 4.35081 9.11816 4.75577C9.2862 5.16074 9.3727 5.59488 9.3727 6.03333C9.3727 6.47178 9.2862 6.90592 9.11816 7.31089C8.95012 7.71586 8.70383 8.08369 8.39341 8.39333ZM13.1067 13.1067C13.0448 13.1692 12.971 13.2187 12.8898 13.2526C12.8086 13.2864 12.7214 13.3039 12.6334 13.3039C12.5454 13.3039 12.4583 13.2864 12.377 13.2526C12.2958 13.2187 12.2221 13.1692 12.1601 13.1067L10.7467 11.6933C10.6843 11.6314 10.6347 11.5576 10.6008 11.4764C10.567 11.3951 10.5495 11.308 10.5495 11.22C10.5495 11.132 10.567 11.0449 10.6008 10.9636C10.6347 10.8824 10.6843 10.8086 10.7467 10.7467C10.8087 10.6842 10.8825 10.6346 10.9637 10.6007C11.0449 10.5669 11.1321 10.5495 11.2201 10.5495C11.3081 10.5495 11.3952 10.5669 11.4765 10.6007C11.5577 10.6346 11.6314 10.6842 11.6934 10.7467L13.1067 12.16C13.1692 12.222 13.2188 12.2957 13.2527 12.3769C13.2865 12.4582 13.3039 12.5453 13.3039 12.6333C13.3039 12.7213 13.2865 12.8085 13.2527 12.8897C13.2188 12.971 13.1692 13.0447 13.1067 13.1067Z"
                            fill="#BBC3CF"></path>
                    </svg>
                    <label for="search" class="sr-only">Rechercher par nom, prénom, courriel, expérience ou biographie ... </label>
                    <input
                        wire:model="search"
                        class="pl-4 pr-4 py-2 w-full text-coolGray-400 font-medium bg-transparent border-none focus:ring-0"
                        id="search" type="search" placeholder="Rechercher..." contenteditable="false">
                    @error('search') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
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
                @if($animateurs->count()<1)
                    <li class="bg-reg-100 text-red-700 px-4 py-3 my-2 rounded relative">Aucune personne correspondant à ces critères trouvée. Veuillez modifier vos critères de recherche.</li>
                @else
                    @foreach($animateurs as $animateur)
                        <li class="py-5">
                            <details class="group">
                                <summary class="flex justify-between items-center font-medium cursor-pointer list-none">
                                    <h3 class="h5">{{$animateur->Prenom}} {{$animateur->Nom}} ({{$animateur->Expertise}})
                                        @unless($animateur->Actif)
                                            <span class="py-1 px-2 ml-2 no-underline rounded-full bg-red-800 text-white font-semibold text-sm border-red-800 hover:text-white hover:bg-red-500 focus:outline-none">Archivé.e</span>
                                        @endunless
                                    </h3>
                                    <span class="transition group-open:rotate-180">
                                     <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                    </span>
                                </summary>
                                <div class="text-neutral-600 mt-3 p-4 bg-gray-50 group-open:animate-fadeIn">
                                    <h4 class="font-semibold mb-2">Biographie</h4>
                                    <p>{{$animateur->Biographie}}</p>
                                    <a href="mail-to:{{$animateur->Courriel}}" class="email block mt-4">{{$animateur->Courriel}}</a>
                                    {{-- Si l'utilisateur est un administrateur ou bien un employé --}}
                                    @can('estAdmin')
                                        <div class="flex justify-end">
                                            <a href="{{route('animateurs.edit', $animateur->id)}}" class="inline-block hover:bg-gray-100 p-2 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                                </svg>
                                                <span class="sr-only">Modifier</span>
                                            </a>
                                            @if($animateur->Actif)
                                                @livewire('modals.archiver-animateur', ['objet' => $animateur], key('archive-'.$animateur->id))
                                            @endif
                                            @livewire('modals.supprimer-animateur', ['objet' => $animateur], key('delete-'.$animateur->id))
                                        </div>
                                    @endcan
                                </div>
                            </details>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        @if($animateurs->hasPages())
            <div class="border-coolGray-10 bg-gray-50 rounded-md shadow-dashboard mt-2 p-2">
                {{$animateurs->links()}}
            </div>
        @endif
    </div>
</section>

