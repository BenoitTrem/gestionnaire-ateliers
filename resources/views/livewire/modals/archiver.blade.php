<div x-cloak x-data="{ open: false }" class="inline-block">
    <button x-on:click="open = ! open" class="hover:bg-gray-100 p-2 rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
        </svg>
        <span class="sr-only">Archiver</span>
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
                    <button wire:click="archiver({{$objet}})" x-on:click="open = false"
                            class="modal-confirm">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
