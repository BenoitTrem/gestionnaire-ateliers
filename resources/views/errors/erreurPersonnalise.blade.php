<x-app-layout>
    <section class="min-h-screen bg-image relative">
        <div class="relative z-10 px-8 py-12">
            <div class="erreur-container min-w-[900px]">
                <h1 class="text-red-700 px-4 py-3 my-2 rounded relative text-center text-3xl">Erreur</h1>
                <p class="text-red-700 px-4 py-3 rounded relative text-center text-xl">
                    {{ session('erreur_message', 'Mauvaise demande.') }}
                </p>
            </div>
        </div>
    </section>
</x-app-layout>
