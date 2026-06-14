<x-guest-layout>
    <section class="form-container">
        <div class="container-padding">
            <div class="text-center max-w-md mx-auto">
                <h2 class="header-title mb-12 text-6xl md:text-7xl text-center font-semibold my-auto" contenteditable="false">SSHCO</h2>
                <h2 class="text-gray-600 mb-6 text-6xl md:text-5xl text-center my-auto" contenteditable="false">Réinitialisation du mot de passe</h2>

                <form method="POST" action="{{ route('password.store') }}" class="mt-4">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <label class="input-label">Courriel
                        <x-text-input id="email" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    </label>
                    @error('email')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Password -->
                    <label class="input-label mt-4">Mot de passe
                        <x-text-input id="password" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" type="password" name="password" required autocomplete="new-password" />
                    </label>
                    @error('password')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Confirm Password -->
                    <label class="input-label mt-4">Confirmer le mot de passe
                        <x-text-input id="password_confirmation" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </label>
                    @error('password_confirmation')
                    <p class="input-error">{{ $message }}</p>
                    @enderror
                    <div class="flex items-center justify-center mt-8">
                        <button class="button">
                            {{ __('Réinitialiser le mot de passe') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
