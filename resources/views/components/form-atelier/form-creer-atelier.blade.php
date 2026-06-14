<!-- @author Benoit Tremblay -->

<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<section class="min-h-screen bg-image relative">
    <div class="space"></div>
    <div class="form-atelier-container">
        <div class="flex justify-between items-center">
            <h1 class="header-text_2">Créer un nouvel atelier</h1>
            <a href="{{ route('ateliers.index') }}" class="button">
                Retourner à la liste
            </a>
        </div>
        <form method="POST" action="{{ route('ateliers.store') }}">
            @csrf

            <div class="form-group">
                <x-input-label for="nom" class="mt-12">Nom de l'atelier *</x-input-label>
                <input type="text" name="nom" id="nom" class="text-input" value="{{old('nom')}}" maxlength="30" minlength="1" required>
                @error('nom')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="animateur" class="mt-8">Choisir un animateur(s)</x-input-label>
                <select name="animateurs[]" id="animateur" multiple>
                    @foreach ($animateurs as $animateur)
                        <option value="{{ $animateur->id }}"
                            {{ (collect(old('animateurs'))->contains($animateur->id)) ? 'selected' : '' }}>
                            {{ $animateur->prenom }} {{ $animateur->nom }}
                        </option>
                    @endforeach
                </select>
                @error('animateurs')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="description" class="mt-8">Description *</x-input-label>
                <textarea name="description" id="description" class="text-input" style="resize: both; max-width: 100%; max-height: 200px;" maxlength="150" minlength="1" required>{{ old('description', $local->description ?? '') }}</textarea>
                @error('description')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="campus_id" class="mt-8">Campus</x-input-label>
                <select name="campus_id" id="campus_id" class="text-input">
                    <option value="" {{ old('campus_id') == '' ? 'selected' : '' }}>Aucun campus</option>
                    @foreach ($campuses as $campus)
                        <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                            {{ $campus->nom }}
                        </option>
                    @endforeach
                </select>


                @error('campus_id')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="local_id" class="mt-8">Choisir un local</x-input-label>
                <select name="local_id" id="local_id" class="text-input"
                        data-old-value="{{ old('local_id') }}">
                    <option value="" {{ old('local_id') == '' ? 'selected' : '' }}>Aucun local</option>
                    @foreach ($locals as $local)
                        <option value="{{ $local->id }}" {{ old('local_id') == $local->id ? 'selected' : '' }}>
                            Local {{ $local->numeroLocal }} (Capacité: {{ $local->capacite }})
                        </option>
                    @endforeach
                </select>


                @error('local_id')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="url_inscription" class="mt-8">URL</x-input-label>
                <input type="url" name="url_inscription" id="url_inscription" class="text-input" value="{{ old('url_inscription') }}">
            </div>

            <div class="form-group">
                <x-input-label for="date" class="mt-8">Date *</x-input-label>
                <input type="date" name="date" id="date" class="text-input"
                       min="{{ \Carbon\Carbon::parse(config('app.edition.debut_semaine'))->isoFormat('YYYY-MM-DD') }}"
                       max="{{ \Carbon\Carbon::parse(config('app.edition.fin_semaine'))->isoFormat('YYYY-MM-DD') }}" value="{{ old('date') }}" required>
                @error('date')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group">
                <x-input-label for="heure_debut" class="mt-8">Heure de début *</x-input-label>
                <select type="number" name="heure_debut" id="heure_debut" class="text-input" required>
                    @for ($hour = 8; $hour <= 23; $hour++)
                        <option value="{{ sprintf('%02d:00', $hour) }}"
                            {{ old('heure_debut') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                            {{ sprintf('%02d:00', $hour) }}
                        </option>
                    @endfor
                </select>
                @error('heure_debut')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <x-input-label for="duree_minutes" class="mt-8">Durée (en minutes) *</x-input-label>
                <input type="number" name="duree_minutes" id="duree_minutes" class="text-input" value="{{ old('duree_minutes') }}" max="300" min="30" required>
                @error('duree_minutes')
                <p class="input-error">{{$message}}</p>
                @enderror
            </div>

            <div class="button-container">
                <button type="submit" class="button mt-5">Créer l'atelier</button>
            </div>
        </form>
    </div>
    <p class="p-28"></p>

    @vite('resources/js/form-atelier.js')

</section>
