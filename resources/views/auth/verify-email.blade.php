<x-guest-layout>
    <section class="form-container">
        <div class="container-padding">
            <div class="text-center max-w-md mx-auto">
                <h2 class="header-title mb-12 text-6xl md:text-7xl text-center font-semibold my-auto" contenteditable="false">SSHCO</h2>
                <h2 class="text-gray-600 mb-6 text-6xl md:text-5xl text-center my-auto" contenteditable="false">Vérification de l'e-mail</h2>

                <div class="text-sm text-gray-600">
                    {{ __('Merci de votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ? Si vous ne l\'avez pas reçu, nous vous en enverrons un autre avec plaisir.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse e-mail que vous avez fournie lors de votre inscription.') }}
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between">
                    <!-- Resend Verification Email Form -->
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                        @csrf
                        <div class="flex justify-center mt-6">
                            <button class="button">
                                @lang('Réenvoyer le e-mail de vérification')

                            </button>
                        </div>
                    </form>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <div class="flex justify-center mt-8">
                        <button type="submit" class="text-gray-600 hover:text-red-700 underline text-lg">
                            {{ __('Se déconnecter') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
