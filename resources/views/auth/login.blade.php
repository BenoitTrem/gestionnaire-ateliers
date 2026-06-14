<x-guest-layout>
        <section class="form-container">
            <section class="image-logo-co"></section>
            <div class="container-padding">
                <div class="text-center max-w-md mx-auto">
                    <h2 class="header-title" contenteditable="false">SSHCO</h2>
                    <form method="POST" action="{{ route('login') }}" class="mt-4">
                        @csrf
                        <label class="input-label"> Courriel *
                            <input class="text-input w-full text-black font-medium  outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" id="signInInput2-1" type="text" name="email" value='{{old('email')}}'>
                        </label>
                        @error('email')
                        <p class="input-error mb-4">{{ $message }}</p>
                        @enderror
                        <label class="input-label"> Mot de passe *
                            <input class="text-input px-4 pr-36 py-3.5 w-full text-black font-medium  outline-none border border-white rounded-lg focus:ring focus:ring-gray-600" id="signInInput2-2" name="password" type="password">
                        </label>
                        @error('password')
                        <p class="input-error">{{ $message }}</p>
                        @enderror

                        <button class="button mt-6" type="submit">Connexion</button>
                        <p class="font-medium text-gray-600 mt-8">
                            <span>Vous n'avez pas de compte?</span>
                            <a class="text-gray-600 hover:text-red-700 underline text-lg" href="{{ route('register') }}">S'inscrire</a>
                        </p>
                        <a class="forgot-password text-lg mt-4 block" href="{{ route('password.request') }}">J'ai oublié mon mot de passe</a>
                    </form>
                </div>
            </div>
        </section>
</x-guest-layout>
