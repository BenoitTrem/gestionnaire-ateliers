<!-- @author Benoit Tremblay -->
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-3xl text-black">
            {{ __('Accueil') }}
        </h1>
    </x-slot>

    <section class="min-h-screen bg-image relative ">
        <div class="space"></div>
        <div x-data="{
            userId: '{{ Auth::id() }}',
            open: sessionStorage.getItem('loggedInAlert_' + '{{ Auth::id() }}') !== 'closed'}"
             x-show="open"
             x-init="
                if (!sessionStorage.getItem('loggedInAlert_' + '{{ Auth::id() }}')) {
                    open = true;
                    setTimeout(() => {
                        open = false;
                        sessionStorage.setItem('loggedInAlert_' + userId, 'closed');
                }, 5000);
            }"
             x-transition:enter="transition-opacity duration-500" x-transition:leave="transition-opacity duration-500 opacity-0"
            class="fixed bottom-0 right-0 m-4 supprimer-container z-50 mb-14 mr-28 transition-opacity duration-500
            bg-white shadow-lg rounded-lg px-4 py-2 flex items-center gap-4">
            <span class="text-sm font-medium text-black">
                {{ __('Vous êtes connecté!') }}
            </span>

            <button @click="
                open = false;
                sessionStorage.setItem('loggedInAlert_' + userId, 'closed');"
                        class="text-black hover:text-red-600 transition duration-300 flex items-center">
                <svg class="fill-current h-5 w-5" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Fermer</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center mt-8">
            <div x-data="{ hovered: false }"
                 @mouseenter="hovered = true"
                 @mouseleave="hovered = false"
                 class="relative w-[1200px] h-[250px] cursor-pointer overflow-hidden">
                <div class="carte-accueil-face"
                     :class="hovered ? 'opacity-0' : 'opacity-100'">
                    <div class="w-full h-full bg-science-humaine relative flex items-start justify-center">
                        <h2 class="absolute top-2 text-3xl text-white font-bold text-center bg-black/30 backdrop-blur-md px-4 py-1 rounded-lg">
                            Semaine des sciences humaines
                        </h2>
                    </div>
                </div>
                <div class="carte-accueil-back"
                     :class="hovered ? 'opacity-80' : 'opacity-0'">
                    <p class="text-lg text-center leading-relaxed tracking-wide text-black">
                        La Semaine des sciences humaines permet aux étudiants et étudiantes du programme sciences humaines de
                        vivre l’expérience d’un colloque scientifique et d’aborder une thématique précise sous divers angles liés aux
                        sciences humaines. Par conséquent, elle permet aux participants et participantes de comprendre l’apport
                        et l’interrelation des diverses sciences humaines dans sa compréhension de l’être humain.
                        De plus, toute la communauté du cégep est invitée à participer à l’événement.
                    </p>
                </div>
            </div>
            <div class="flex gap-4 mt-4">
                <div x-data="{ hovered: false }"
                     @mouseenter="hovered = true"
                     @mouseleave="hovered = false"
                     class="relative w-[683px] h-[400px] cursor-pointer overflow-hidden">
                    <div class="carte-accueil-face"
                         :class="hovered ? 'opacity-0' : 'opacity-100'">
                        <div class="w-full h-full bg-conference relative flex items-start justify-start">
                            <h2 class="absolute top-2 left-2 text-3xl text-white font-bold bg-black/30 backdrop-blur-md px-4 py-1 rounded-lg">
                                Ateliers et projections
                            </h2>
                        </div>
                    </div>
                    <div class="carte-accueil-back"
                         :class="hovered ? 'opacity-80' : 'opacity-0'">
                        <p class="text-lg text-center leading-relaxed tracking-wide text-black">
                            En plus des nombreux ateliers offerts durant la semaine, les participant(e)s pourront aussi
                            participer à des ateliers et assister à quelques projections cinématographiques...
                        </p>
                    </div>
                </div>
                <div x-data="{ hovered: false }"
                     @mouseenter="hovered = true"
                     @mouseleave="hovered = false"
                     class="relative w-[500px] h-[500px] cursor-pointer overflow-hidden">
                    <div class="carte-accueil-face"
                         :class="hovered ? 'opacity-0' : 'opacity-100'">
                        <div class="w-full h-full bg-video relative flex items-start justify-end">
                            <h2 class="absolute top-2 right-2 text-3xl text-white font-bold bg-black/30 backdrop-blur-md px-4 py-1 rounded-lg">
                                Événements simultanés
                            </h2>
                        </div>
                    </div>
                    <div class="carte-accueil-back"
                         :class="hovered ? 'opacity-80' : 'opacity-0'">
                        <p class="text-lg text-center leading-relaxed tracking-wide text-black">
                            Par ailleurs, la Semaine des sciences humaines et le Salon des arts, lettres et communication ont lieu en simultané.
                            Ainsi, les personnes inscrites à un ou l’autre de ces événements pourront participer à l’ensemble de la programmation.
                            Certaines conférences se déroulant en direct du campus Gabrielle-Roy seront accessibles à la communauté
                            de Félix-Leclerc via vidéodiffusion.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <p class="p-20"></p>
    </section>
    <x-footer />
</x-app-layout>
