<!-- @author John Sebastian Sebastian -->

<section class="min-h-screen bg-image relative">
    <div class="space"></div>
    <div class="form-animateur-container">

        <div class="flex justify-between items-center">
            <h1 class="header-text_2">Créer un nouvel animateur</h1>
            <a href="{{ route('animateurs.index') }}" class="button">
                Retourner à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('animateurs.store') }}">
            @csrf


            <div class="form-group">
                <x-input-label for="nom" class="mt-12">Nom *</x-input-label>
                <input type="text" name="nom" id="nom" class="text-input" value="{{ old('nom') }}" maxlength="15">
                @error('nom')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>


            <div class="form-group">
                <x-input-label for="prenom" class="mt-8">Prénom *</x-input-label>
                <input type="text" name="prenom" id="prenom" class="text-input" value="{{ old('prenom') }}" maxlength="15">
                @error('prenom')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>


            <div class="form-group">
                <x-input-label for="email" class="mt-8">Email *</x-input-label>
                <input type="email" name="email" id="email" class="text-input" value="{{ old('email') }}">
                @error('email')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="biographie" class="mt-8">Biographie</x-input-label>
                <textarea name="biographie" id="biographie" class="text-input" style="resize: both; max-width: 100%; max-height: 200px;">{{ old('biographie') }}</textarea>
                @error('biographie')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>


            <div class="form-group">
                <x-input-label for="expertise" class="mt-8">Expertise</x-input-label>
                <input type="text" name="expertise" id="expertise" class="text-input" value="{{ old('expertise') }}">
                @error('expertise')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="button-container">
                <button type="submit" class="button mt-5">Créer l'animateur</button>
            </div>
        </form>
    </div>
    <p class="p-28"></p>
</section>
