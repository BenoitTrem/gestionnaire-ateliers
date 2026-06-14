//@author Benoit Tremblay

// j'ai utilisé du code que j'ai trouvé sur ce site:
//      https://www.npmjs.com/package/choices.js/v/9.0.1
document.addEventListener('DOMContentLoaded', function () {
    const element = document.getElementById('animateur');
    if (element) {
        const choices = new Choices(element, {
            removeItemButton: true,
            placeholder: true,
            placeholderValue: 'Rechercher...',
            searchPlaceholderValue: 'Rechercher...',
            itemSelectText: 'Cliquer pour sélectionner',
            noResultsText: 'Aucun résultat trouvé.',
            noChoicesText: 'Aucun choix',
            shouldSort: false
        });
    }

    // J'ai utilisé ChatGpt pour récuprer les locaux disponible par le campus choisi.

    // Récupère le Id des <select> dans les formulaires pour le campus et le local
    const campusSelect = document.getElementById('campus_id');
    const localSelect = document.getElementById('local_id');

    function populateLocals(campusId, selectedLocalId = null) {
        // Envoie une requête GET pour récupérer les locaux du campus sélectionné
        fetch(`/locals-by-campus/${campusId}`)
            .then(response => response.json())
            .then(data => {
                localSelect.innerHTML = '';

                // Si aucun local n'est disponible, affiche un message
                if (data.length === 0) {
                    const noOption = document.createElement('option');
                    noOption.textContent = 'Aucun local disponible';
                    noOption.disabled = true;
                    noOption.selected = true;
                    localSelect.appendChild(noOption);
                    return;
                }

                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = 'Sélectionner un local';
                placeholderOption.disabled = true;
                if (!selectedLocalId) placeholderOption.selected = true;
                localSelect.appendChild(placeholderOption);

                // Ajout à la liste déroulante
                data.forEach(local => {
                    const option = document.createElement('option');
                    option.value = local.id;
                    option.textContent = `Local ${local.numeroLocal} (Capacité: ${local.capacite})`;
                    if (selectedLocalId && parseInt(selectedLocalId) === local.id) {
                        option.selected = true;
                    }
                    localSelect.appendChild(option);
                });
            });
    }

    if (campusSelect) {
        campusSelect.addEventListener('change', function () {
            const campusId = this.value;

            // Si aucun campus n'est sélectionné, réinitialise le champ des locaux
            if (!campusId) {
                localSelect.innerHTML = '<option value="">Aucun local</option>';
                return;
            }
            populateLocals(campusId);  // Appelle la fonction pour mettre à jour les locaux en fonction du campus choisi
        });

        const oldCampusId = campusSelect.getAttribute('data-old-value');
        const oldLocalId = localSelect.getAttribute('data-old-value');

        if (oldCampusId) {
            campusSelect.value = oldCampusId;
            populateLocals(oldCampusId, oldLocalId);
        }
    }
});
