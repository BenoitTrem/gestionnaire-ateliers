<x-guest-layout>
    <section class="form-container">
        <section class="image-logo-co"></section>
        <div class="container-padding">
            <div class="text-center max-w-md mx-auto">
                <h2 class="header-title mb-6 text-6xl md:text-7xl text-center font-semibold my-auto" contenteditable="false">SSHCO</h2>
                <form method="POST" action="{{ route('register') }}" class="mt-4">
                    @csrf

                    <!-- Nom -->
                    <label class="input-label">Nom *
                        <input id="nom" type="text" name="nom" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" value="{{ old('nom') }}" required autofocus autocomplete="nom">
                    </label>
                    @error('nom')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Prenom -->
                    <label class="input-label">Prénom *
                        <input id="prenom" type="text" name="prenom" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" value="{{ old('prenom') }}" required autofocus autocomplete="prenom">
                    </label>
                    @error('prenom')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Email -->
                    <label class="input-label mt-4">Courriel *
                        <input id="email" type="email" name="email" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" value="{{ old('email') }}" required autocomplete="username">
                    </label>
                    @error('email')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Password -->
                    <label class="input-label mt-4">Mot de passe *
                        <input id="password" type="password" name="password" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" required autocomplete="new-password">
                    </label>
                    @error('password')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Confirm Password -->
                    <label class="input-label mt-4">Confirmer le mot de passe *
                        <input id="password_confirmation" type="password" name="password_confirmation" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" required autocomplete="new-password">
                    </label>
                    @error('password_confirmation')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" class="button mt-6">S'inscrire</button>

                    <!-- Already Registered Link -->
                    <p class="font-medium text-gray-600 mt-8">
                        <span>Vous êtes déjà inscrit?</span>
                        <a class="text-gray-600 hover:text-red-700 underline text-lg" href="{{ route('login') }}">Se connecter</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
