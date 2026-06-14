<!-- @author John Sebastian Sebastian -->

<x-guest-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading- my-auto">
            {{ __('Détails de l\'Animateur') }}
        </h1>
    </x-slot>

    <section class="py-4">
        <div class="px-4 mx-auto">
            <div class="flex flex-wrap items-center justify-between -m-2">
                <div class="w-full flex flex-wrap items-center text-white text-2xl">
                    <h2 class="text-coolGray-900 font-semibold my-4">
                        <span>{{ $animateur->prenom }} {{ $animateur->nom }}</span>
                    </h2>
                </div>
            </div>



            <div class="bg-white shadow rounded-lg p-6 mt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Informations de l'animateur</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <li><strong>Nom :</strong> {{ $animateur->prenom }} {{ $animateur->nom }}</li>
                    <li><strong>Email :</strong> <a href="mailto:{{ $animateur->email }}" class="text-blue-500 hover:underline">{{ $animateur->email }}</a></li>
                    <li><strong>Biographie :</strong> {{ $animateur->biographie }}</li>
                    <li><strong>Expertise :</strong> {{ $animateur->expertise }}</li>
                </ul>
            </div>

            <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Ateliers assignés</h3>
                @if($animateur->ateliers->isEmpty())
                    <p class="text-red-600">Aucun atelier assigné.</p>
                @else
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        @foreach($animateur->ateliers as $atelier)
                            <li><strong>Nom :</strong>{{$atelier->nom}}</li>
                            <li><strong>Durée :</strong> {{ $atelier->duree_minutes }} minutes</li>
                            @if($atelier->date)
                                <li><strong>Date :</strong> {{ \Carbon\Carbon::parse($atelier->date)->format('d M Y') }} à {{ $atelier->heure_debut }}</li>
                            @endif
                            <li><strong>Campus :</strong> {{ $atelier->campus->nom ?? 'N/A' }}</li>

                            <li><strong>Local :</strong> {{ optional($atelier->local)->numeroLocal ?? 'N/A' }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>
</x-guest-layout>
