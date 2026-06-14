<!-- @author Benoit Tremblay -->
<x-guest-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading- my-auto">
            {{ __('custom.Users') }}
        </h1>
    </x-slot>
    <section class="py-4">
        <div class="px-4 mx-auto">
            <div class="flex flex-wrap items-center justify-between -m-2">
                <div class="w-full flex flex-wrap items-center text-white text-2xl">
                    <h2 class="text-coolGray-900 font-semibold my-4" contenteditable="false">
                        <span>Liste d'inscriptions pour "{{$atelier->Nom}}"
                            @if(method_exists($atelier, 'getListeAnimateurs') && $atelier->getListeAnimateurs())
                                par {{$atelier->getListeAnimateurs()}}
                            @endif
                        </span>
                        <!-- Vérification si la méthode getDateCarbon existe avant de l'appeler -->
                        @if(method_exists($atelier, 'getDateCarbon'))
                            <span>({{$atelier->getDateCarbon()->isoformat('D MMMM YYYY')}} {{$atelier->HeureDebut}}, {{$atelier->campus->Nom ?? 'Campus inconnu'}})</span>
                        @endif
                    </h2>
                </div>
            </div>
            <div class="flex justify-end -mx-2">
                <a href="{{route('atelier-imprimer', $atelier->id)}}" target="_blank" class="inline-flex text-neutral-50 p-4 hover:text-gray-600" title="Imprimer la liste de présences">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    <span class="sr-only">Imprimer la liste</span>
                </a>
            </div>
            <div x-data="{ open: true }">
                @if (session()->has('message'))
                    <div x-show="open" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-2 -mx-2 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                        <button class="absolute top-0 bottom-0 right-0 px-4 py-3" x-on:click="open = false">
                            &times;
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-guest-layout>
