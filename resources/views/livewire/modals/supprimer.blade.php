<div x-cloak x-data="{ open: false }" class="inline-block">
    <button x-on:click="open = ! open" class="hover:bg-gray-100 p-2 rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
        </svg>
        <span class="sr-only">Supprimer</span>
    </button>
    <div
        x-show.transition.origin.top.right.duration.500ms="open"
        class="modal fade fixed top-0 left-0 right-0 bottom-0
        flex items-center w-full h-full p-4 bg-gray-100/50 overflow-y-auto transition duration-150 ease-in-out"
        id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="max-w-lg w-full m-auto p-8 bg-white border rounded-lg">
            <h3 class="mb-2 text-xl font-semibold text-coolGray-900">{{$titre}}</h3>
            <p class="mt-4 mb-3 font-medium text-sm text-coolGray-500">
                {{$message}}
            </p>
            <div class="flex flex-wrap justify-end mt-4">
                <div class="w-full md:w-1/2">
                    <button x-on:click="open = false"
                            class="modal-cancel !ml-0">
                        Annuler
                    </button>
                </div>
                <div class="w-full md:w-1/2">
                    <button wire:click="delete({{$objet}})" x-on:click="open = false"
                            class="modal-confirm">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
