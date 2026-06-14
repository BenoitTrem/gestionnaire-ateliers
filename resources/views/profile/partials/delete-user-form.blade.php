<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Supprimer le compte') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
        </p>
    </header>

    <button
        class="button-sup"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Supprimer le compte') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 form-profil_2">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer la suppression définitive de votre compte.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 text-input"
                    placeholder="{{ __('Mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 ">
                <button type="button" class="primary-button_2 w-full max-w-[150px]" x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </button>

                <button class="ms-3 secondary-button">
                    {{ __('Supprimer le compte') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
