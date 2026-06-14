<x-guest-layout>
    <section class="form-container">
        <div class="container-padding">
            <div class="text-center max-w-md mx-auto">
                <h2 class="header-title mb-12 text-6xl md:text-7xl text-center font-semibold my-auto" contenteditable="false">SSHCO</h2>
                <h2 class="text-gray-600 mb-6 text-6xl md:text-5xl text-center my-auto" contenteditable="false">Confirmer le mot de passe</h2>
                <div class="text-sm text-gray-600">
                    {{ __('Ceci est une zone sécurisée de l\'application. Veuillez confirmer votre mot de passe avant de continuer.') }}
                </div>
                <form method="POST" action="{{ route('password.confirm') }}" class="mt-4">
                    @csrf

                    <label class="input-label">Mot de passe
                        <x-text-input id="password" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" type="password" name="password" required autocomplete="current-password" />
                    </label>
                    @error('password')
                    <p class="input-error">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-center mt-8">
                        <button class="button">
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
