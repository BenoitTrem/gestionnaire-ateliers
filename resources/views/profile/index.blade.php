<!-- author John Sebastian Zuleta Franco -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">
            <h1 class="font-bold text-2xl text-black">{{ __('Utilisateurs') }}</h1>

            <form method="GET" action="{{ route('profile.index') }}" class="flex flex-wrap items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <input type="text" name="nom" id="nom" value="{{ request('nom') }}" class="text-input w-full sm:w-64" placeholder="Nom de l'utilisateur">
                <div class="flex gap-2">
                    <button type="submit" class="btnFiltrer">Filtrer</button>
                    <a href="{{ route('profile.index') }}" class="btnFiltrer">Réinitialiser</a>
                </div>
            </form>

            <form action="{{ route('profile.filtrerRole') }}" method="GET" class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <label for="order" class="mr-2">Filtrer par rôle :</label>
                <select name="order" id="order" class="form-control inputFiltrer">
                    <option value="asc" {{ request()->get('order') == 'asc' ? 'selected' : '' }}>Ascendant</option>
                    <option value="desc" {{ request()->get('order') == 'desc' ? 'selected' : '' }}>Descendant</option>
                </select>
                <button type="submit" class="btnFiltrer">Filtrer</button>
            </form>
        </div>

        @if (session()->has('erreur'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-2 rounded relative" role="alert">
                <span>{{ session('erreur') }}</span>
            </div>
        @endif
    </x-slot>

    <section class="min-h-screen bg-image relative">
        <div class="relative z-10 px-8 py-12">
            @if(session('user_modifier'))
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="p-6 form-profil_2">
                        <h3 class="text-xl font-medium text-gray-900">
                            Le rôle de l'utilisateur "<span class="font-bold">{{ session('nom_utilisateur') }}</span>" a été modifié avec succès !
                        </h3>
                        <div class="flex justify-center">
                            <button class="mt-4 w-full max-w-[150px] button-modal" onclick="this.closest('div[class*=fixed]').remove();">Fermer</button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="animateur-container min-w-[900px]">
                <ul class="grid divide-y divide-neutral-200 mx-auto">
                    @forelse($users as $user)
                        <li class="py-8">
                            <div class="user-card bg-white shadow-md rounded-lg overflow-hidden transition hover:shadow-lg">
                                <div class="flex justify-between items-center p-4 font-semibold cursor-pointer bg-gray-100 toggle-user-details" data-user-id="{{ $user->id }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center rounded-full text-black font-bold text-lg bg-blue-400">
                                            {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                                        </div>
                                        <h2 class="text-lg">{{ $user->prenom }} {{ $user->nom }}</h2>
                                    </div>
                                    <span class="arrow transition-transform transform" id="arrow-{{ $user->id }}">▼</span>
                                </div>

                                <div class="user-details hidden p-5 bg-white border-t border-gray-200" id="details-{{ $user->id }}">
                                    <h2 class="font-semibold text-gray-900 mb-2">Détails de l'utilisateur</h2>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li><strong>Nom :</strong> {{ $user->prenom }} {{ $user->nom }}</li>
                                        <li><strong>Email :</strong> {{ $user->email }}</li>
                                        <li><strong>Rôle actuel :</strong>
                                            @if($user->role == 2) Admin
                                            @elseif($user->role == 1) Organisateur
                                            @else Utilisateur
                                            @endif
                                        </li>
                                    </ul>

                                    @php
                                        $canEdit = auth()->user()->role == 2 && $user->role == 3
                                            || auth()->user()->role == 1 && in_array($user->role, [3, 2]);
                                    @endphp

                                    @if($canEdit)
                                        <div class="flex justify-end space-x-4 mt-4">
                                            <a href="#" class="button-modifier"
                                               onclick="openRoleModal({{ $user->id }}, '{{ $user->role }}')">
                                                Changer le rôle
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-red-700 px-4 py-3 my-2 rounded relative text-center">
                            Aucun utilisateur trouvé. Veuillez en ajouter un.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        @if($users->hasPages())
            <div class="flex justify-center mt-4">
                {{ $users->links() }}
            </div>
        @endif

        <div id="roleModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="bg-white p-6 rounded shadow-md max-w-sm w-full">
                <h3 class="text-lg font-bold mb-4">Modifier le rôle de l'utilisateur</h3>
                <form method="POST" action="{{ route('profile.updateRole') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" id="modalUserId">
                    <label class="block mb-2 font-medium" for="role">Rôle</label>
                    <select name="role" id="modalUserRole" class="w-full p-2 border rounded">
                        <option value="2">Admin</option>
                        @can('organisateur')
                            <option value="3">Utilisateur</option>
                        @endcan
                    </select>
                    <div class="flex justify-end mt-4 space-x-2">
                        <button type="button" onclick="closeRoleModal()" class="bg-gray-300 px-4 py-2 rounded">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <x-footer />
</x-app-layout>
