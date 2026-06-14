<div x-cloak x-data="{ open: false }" class="inline-block">
    <button x-on:click="open = ! open" class="inline-block hover:bg-gray-100 p-2 rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
        </svg>
        <span class="sr-only">Modifier le rôle</span>
    </button>
    <div
        x-show.transition.origin.top.right.duration.500ms="open"
        class="modal fade fixed top-0 left-0 right-0 bottom-0
        flex items-center w-full h-full p-4 bg-gray-100/50 overflow-y-auto transition duration-150 ease-in-out"
        id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="max-w-lg w-full m-auto px-8 pt-8 pb-4 bg-white border rounded-lg">
            <h3 class="mb-4 text-2xl font-semibold text-coolGray-900">
                Modifier le rôle de {{$user->firstname}} {{$user->name}}</h3>
            <p class="mt-4 mb-3 text-coolGray-500">
                Choisir le nouveau rôle de {{$user->firstname}} {{$user->name}} :
            </p>
            <div class="mb-6 w-full">
                <label for="role-user-{{$user->id}}-{{$mode}}" class="sr-only">Modifer le rôle</label>
                <select wire:model="modifRole" id="role-user-{{$user->id}}-{{$mode}}" class="form-select appearance-none block w-full mb-3 text-base font-normal text-gray-700
                  bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}" @selected($user->idTypeCompte === $role->id)>{{$role->Nom}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-wrap justify-end mt-4">
                <div class="w-full md:w-1/2">
                    <button x-on:click="open = false" class="modal-cancel !ml-0">
                        Annuler
                    </button>
                </div>
                <div class="w-full md:w-1/2">
                    <button wire:click="changerRole()" x-on:click="open = false" class="modal-confirm">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
