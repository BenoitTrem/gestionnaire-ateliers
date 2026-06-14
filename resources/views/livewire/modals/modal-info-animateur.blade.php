<div x-cloak x-data="{ open: false}" class="inline-block">
    <button x-on:click="open = ! open" class = "inline-flex items-center text-semibold rounded mt-1 mr-1 px-2 text-blue-900 dark:text-blue-900 hover:underline">
        {{$animateur->Prenom}} {{$animateur->Nom}}
    </button>
    <div
        x-show.transition.origin.top.right.duration.500ms="open"
        class="modal fade fixed top-0 left-0 right-0 bottom-0 flex items-center w-full h-full p-4 overflow-y-auto transition duration-150 ease-in-out"
        id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1"
        aria-hidden="true">
        <div class="max-w-lg w-full m-auto p-8 bg-white border rounded-lg">
            <h3 class="mb-2 text-xl font-semibold text-coolGray-900">{{$animateur->Prenom}} {{$animateur->Nom}}</h3>
            <p class="mt-4 mb-3 font-medium text-sm text-coolGray-500">
                {{$animateur->Biographie}}
            </p>
            <div class="flex flex-wrap justify-end mt-4">
                <div class="w-full">
                    <button x-on:click="open = false" class="modal-confirm" id="e">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

