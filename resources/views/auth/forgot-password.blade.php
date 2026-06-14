<x-guest-layout>
    <section class="form-container">
        <div class="container-padding">
            <div class="text-center max-w-md mx-auto">
                <h2 class="header-title mb-12 text-6xl md:text-7xl text-center font-semibold my-auto" contenteditable="false">SSHCO</h2>
                <h2 class="text-gray-600 mb-6 text-6xl md:text-5xl text-center my-auto" contenteditable="false">Réinitialisation du mot de passe</h2>

                <div class="text-sm text-gray-600">
                    @lang('Mot de passe oublié ? Aucun problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe qui vous permettra d&rsquo;en choisir un nouveau.')

                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                    @csrf

                    <!-- Email Address -->
                    <label class="input-label">Courriel
                        <x-text-input id="email" class="text-input w-full text-black font-medium outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" type="email" name="email" :value="old('email')" required autofocus />
                    </label>
                    @error('email')
                    <p class="input-error">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <div class="flex items-center justify-center mt-8">
                        <button class="button">
                            {{ __('Réinitialisation du mot de passe par e-mail') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
