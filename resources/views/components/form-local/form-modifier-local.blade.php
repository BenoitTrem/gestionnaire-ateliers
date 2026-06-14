<!-- @author Benoit Tremblay -->
<section class="min-h-screen bg-image relative">
    <div class="space"></div>
    <div class="form-atelier-container">
        <div class="flex justify-between items-center">
            <h1 class="header-text_2">Modification du local {{ $local->numeroLocal}}</h1>
            <a href="{{ route('locaux.index') }}" class="button">
                Retourner à la liste
            </a>
        </div>
        <form method="POST" action="{{ route('locaux.update', $local->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <x-input-label for="numeroLocal" class="mt-12">Nom / Numéro du local *</x-input-label>
                <input type="text" name="numeroLocal" id="numeroLocal" class="text-input"
                       value="{{ old('numeroLocal', $local->numeroLocal) }}" maxlength="10" minlength="1" required>
                @error('numeroLocal')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="campus" class="mt-8">Campus *</x-input-label>
                <select type="text" name="campus_id" id="campus" class="text-input" required>
                    <option value="" disabled>Choisir un campus</option>
                    @foreach ($campuses as $campus)
                        <option value="{{ $campus->id }}"
                            {{ old('campus_id', $local->campus_id) == $campus->id ? 'selected' : '' }}>
                            {{ $campus->nom }}
                        </option>
                    @endforeach
                </select>
                @error('campus_id')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="capacite" class="mt-8">Capacité *</x-input-label>
                <input type="number" name="capacite" id="capacite" class="text-input"
                       value="{{ old('capacite', $local->capacite) }}" max="200" min="1" required >
                @error('capacite')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="disponibilite" class="mt-8"></x-input-label>
                <label for="disponibilite" class="checkbox-container flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="disponibilite" id="disponibilite" class="checkbox-input"
                           value="1"  {{ old('disponibilite', (bool) $local->disponibilite) ? 'checked' : '' }}>
                    <div class="checkbox-custom"></div>
                    <span class="ml-2">Disponible</span>
                </label>
            </div>

    <div class="button-container">
                <button type="submit" class="button mt-5">Modifier le local</button>
            </div>
        </form>
    </div>
    <p class="p-28"></p>
</section>



