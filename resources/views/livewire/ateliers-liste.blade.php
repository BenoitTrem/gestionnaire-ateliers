<div class="flex flex-wrap items-center gap-10">
    <div class="flex items-center gap-2">
        <label for="date" class="font-semibold">Date</label>
        <input wire:model="date" id="date" type="date" name="date"
               class="text-input-recherche min-w-[200px] min-h-[35px]"
               min="{{ \Carbon\Carbon::parse(config('app.edition.debut_semaine'))->isoFormat('YYYY-MM-DD') }}"
               max="{{ \Carbon\Carbon::parse(config('app.edition.fin_semaine'))->isoFormat('YYYY-MM-DD') }}">
    </div>
    @error('date') <p class="form-error">{{ $message }}</p> @enderror

    <div class="flex items-center gap-2">
        <label for="campus_id" class="font-semibold">Campus</label>
        <select wire:model="campus" id="campus_id" name="campus_id"
                class="text-input-recherche min-w-[200px] min-h-[35px]">
            <option value="">Tous</option>
            @foreach ($liste_campus as $campus)
                <option value="{{ $campus->id }}">{{ $campus->nom }}</option>
            @endforeach
        </select>
    </div>
    @error('campus') <p class="form-error">{{ $message }}</p> @enderror

    <div class="flex items-center gap-2">
        <label for="search" class="font-semibold">Rechercher</label>
        <div class="relative flex items-center">
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 z-50 clear-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
            </svg>
            <input wire:model="search" id="search" type="search" placeholder="Rechercher..."
                   class="text-input-recherche pl-8 min-w-[200px] min-h-[35px]">
        </div>
    </div>
    @error('search') <p class="form-error">{{ $message }}</p> @enderror
</div>
