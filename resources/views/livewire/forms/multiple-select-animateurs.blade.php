{{-- Tiré et adapté de https://github.com/GlebRed/Livewire-Search-Multiselect-Input  --}}
<div class="w-full">
    <div class="relative">
        <input wire:model="query"
              class="w-full w-px-4 py-2.5 text-base text-coolGray-900 font-normal outline-none focus:border-blue-500 border border-coolGray-200 rounded-lg shadow-input"
              type="text" placeholder="Rechercher nom, prénom, courriel ou expertise ...">
        @if(!empty($selected_items))
        <select class="hidden" name="animateurs[]" multiple>
            @foreach($selected_items as $selected_item)
                <option value="{{$selected_item->id}}" selected></option>
            @endforeach
        </select>
        @endif
    </div>
    @if(!empty($query))
        <div class="w-full w-px-4 py-2.5 text-base text-coolGray-900 font-normal outline-none focus:border-blue-500 border border-coolGray-200 rounded-lg shadow-input -top-2">
            <ul class="list-none">
                @if(!empty($data))
                    @foreach($data as $i => $animateur)
                    <li wire:click="addSelectedItem({{$animateur['id']}})" class="w-full py-1 px-5 cursor-pointer hover:bg-gray-200">
                        Ajouter {{$animateur['Prenom']}} {{$animateur['Nom']}} ({{$animateur['Expertise']}})
                    </li>
                    @endforeach
                @else
                    <li class="text-red-900 bg-red-100 p-2">Aucun résultat trouvé. Modifiez vos critères de recherche.</li>
                @endif
            </ul>
        </div>
    @endif

    <!-- selections -->
    @if(!empty($selected_items))
        @foreach($selected_items as $selected_item)
            <div class="bg-indigo-100 inline-flex items-center text-sm rounded mt-2 mr-1">
                <span class="ml-2 mr-1 leading-relaxed truncate w-full">{{$selected_item['Prenom']}} {{$selected_item['Nom']}} ({{$selected_item['Expertise']}})</span>
                <button wire:click="removeSelectedItem({{$selected_item['id']}})" type="button"
                        class="w-6 h-8 inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"> <path fill-rule="evenodd"
                              d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"></path>
                    </svg>
                </button>
            </div>
        @endforeach
    @endif
</div>
