<!-- @author Benoit Tremblay -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col">

<nav class="menu-2">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex flex-col items-center text-center">
            <div class="nav-titre">
                SSHCO 2025
            </div>
            <div class="nav-titre-2">
                Cahier de la programmation
            </div>
        </div>

        <div class="flex space-x-7">
            <a href="{{ route('login') }}" class="profile-container">
                Se connecter
            </a>
            <a href="{{ route('register') }}" class="profile-container">
                Inscription
            </a>
        </div>
    </div>
</nav>

<section class="bg-gradient-to-t from-neutral-50 to-neutral-100 shadow-inner">
    <div class="flex flex-wrap items-center justify-center lg:justify-between mx-4">
        <div class="w-full lg:w-1/2 mb-2 lg:mb-0">
            <div class="relative py-1 md:py-2 text-center md:text-start">
                <div class="relative">
                    <h2 class="text-md font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-900 bg-clip-text text-transparent" contenteditable="false">
                        VIENS VIVRE L'EXPÉRIENCE D'UN COLLOQUE SCIENTIFIQUE
                    </h2>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 mb-2 lg:mb-0">
            <div class="relative md:py-2 py-1">
                <div class="relative text-center md:text-start">
                    <h2 class="text-md lg:text-right font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-900 bg-clip-text text-transparent" contenteditable="false">
                        <span id="gris" class="d-block mb-3">INSCRIPTIONS</span>
                        <span class="d-block mb-3">
                            INSCRIPTIONS DU 17 FÉVRIER
                        </span>
                        <span class="d-block">
                            AU 13 MARS 2025
                        </span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="items-center justify-center">
    <section class="min-h-screen relative bg-cover bg-center bg-no-repeat bg-image-accueil">
        <div class="h-full mx-12 pt-16">
            <h1 class="text-3xl tracking-tighter text-white">
                <span class="block mb-4"><span>6<sup>e</sup></span> édition</span>
                <span class="block mb-4">LA SEMAINE DES <span class="font-bold">SCIENCES HUMAINES</span></span>
                <span class="block mb-8 text-bold">CONQUÉRIR</span>
                <span class="block mb-8 text-light">POUR LE MEILLEUR OU LE PIRE?</span>
                <span class="block mb-2">du <span class="font-bold">17</span> au <span class="font-bold">21</span> mars <span
                        class="font-bold">2025</span></span>
            </h1>
        </div>
    </section>
</main>
<x-footer/>
</body>
</html>
