<div x-cloak x-data="{ open: false }" class="{{$css ? '' : 'inline-block'}}">
    <button x-on:click="open = ! open" class="{{$css ?: 'modal-confirm'}}" type="button">
        {{$titre}}
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
                            class="modal-cancel !ml-0" type="button">
                        Annuler
                    </button>
                </div>
                <div class="w-full md:w-1/2">
                    <button type="submit" x-on:click="open = false"
                            class="modal-confirm">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
