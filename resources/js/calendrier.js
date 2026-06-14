//@author Benoit Tremblay

//Pour le fullCalendar j'ai utilisé ce site: https://fullcalendar.io/docs/getting-started et chatGPT puisque je n'avais jamais
//utilisé et fait de calandrier dans le passé. J'ai demandé à ChatGPT quelle était la meilleure solution pour créer un
//calendrier puis il m'a référé au FullCalendar. J'ai principalement utilisé ChatGPT pour la récupération et l'affichage
//d'un atelier avec ses informations (fonction: fetchAteliers, /fetch-ateliers et /fetch-animateur-info dans les routes).
$(document).ready(function() {

    // Initialise le calendrier avec des options personnalisées
    $('#calendar').fullCalendar({
        locale: 'fr',

        // Les dates que le calendrier va montrer
        validRange: {
            start: '2025-03-17',
            end: '2025-03-22'
        },
        defaultView: 'agendaWeek', // vue de la semaine avec les heures

        // Configuration de l'en-tête du calendrier
        header: {
            left: '',
            center: 'title',
            right: ''
        },

        // Chargement dynamique des ateliers depuis le serveur
        events: function(start, end, timezone, callback) {
            var campus = $('#filtreCampus').val();
            $.ajax({
                url: '/fetch-ateliers',
                data: {
                    campus: campus
                },
                success: function(data) {
                    callback(data);
                }
            });
        },
        allDaySlot: false,  // Ne pas afficher la zone "toute la journée"
        editable: false, // Les événements ne peuvent pas être modifiés manuellement
        droppable: true,
        minTime: '08:00:00', // Heure de début du calendrier
        maxTime: '24:00:00', // Heure de fin du calendrier

        // Ouvre le modale quand on clique
        eventClick: function(event) {
            openModal(event);
        },

        // Personnalise l'affichage de chaque atelier
        eventRender: function(event, element) {
            element.find('.fc-title').empty();
            var debut = moment(event.start).format('HH:mm');
            var title = event.title.length > 20 ? event.title.substring(0, 20) + '...' : event.title;
            element.html(`
                        <span>${debut}</span>
                        <span>${title}</span>
                    `);

            // Style CSS d'un atelier
            element.css({
                'min-height': '70px',
                'font-size': '17px',
                'font-weight': '900',  // Mettre en gras pour le texte
                'padding': '8px',
                'height': 'auto',
                'line-height': '1.6',
                'z-index': '9999',
                'word-wrap': 'break-word',
                'white-space': 'normal',
                'box-sizing': 'border-box',
                'border': '1px solid black',
                'color': '#fefefe',  // Le blanc très clair pour le texte
                'border-radius': '8px',  // Ajoute un léger arrondi pour plus de douceur visuelle
                'box-shadow': '0px 4px 6px rgba(0, 0, 0, 0.1)',  // Ajoute une ombre pour améliorer la visibilité
            });
            element.hover(
                function() {
                    $(this).css({
                        'background-color': '#6B7280',
                        'cursor': 'pointer',
                        'transform': 'scale(1.05)',
                        'transition': 'transform 0.2s ease, background-color 0.2s ease'
                    });
                },
                function() {
                    $(this).css({
                        'background-color': event.color,
                        'transform': 'scale(1)'
                    });
                }
            );
        },

        // Détermine si deux ateliers peuvent se chevaucher
        slotEventOverlap: false,

        // Positionnement personnalisé des ateliers
        eventPositioned: function(event, element) {
            var overlappingEvents = element.siblings('.fc-event');
            if (overlappingEvents.length > 0) {
                element.css('margin-top', (overlappingEvents.length + 1) * 20 + 'px');
            }
            var eventStartTime = moment(event.start).format('HH:mm');
            var sameTimeEvents = $('.fc-event').filter(function() {
                return moment($(this).data('start')).format('HH:mm') === eventStartTime;
            });

            // Ajuste la largeur des ateliers ayant la même heure de début
            if (sameTimeEvents.length > 1) {
                var newWidth = (100 / sameTimeEvents.length) - 5;
                element.css('width', newWidth + '%');
            } else {
                element.css('width', '100%');
            }
        },
        slotLabelFormat: 'HH:mm', // Format de l'heure affichée à gauche
        firstDay: 1,  // Lundi comme premier jour de la semaine
        hiddenDays: [0, 6], // Cache le dimanche (0) et le samedi (6)
    });

    // Recharge les ateliers lorsqu'on change le campus
    $('#filtreCampus').on('change', function() {
        $('#calendar').fullCalendar('refetchEvents');
    });

    // Fonction pour ouvrir la modale avec les détails
    function openModal(event) {
        const modal = document.getElementById('atelierModal');
        const atelierTitle = document.getElementById('atelierTitle');
        const atelierDescription = document.getElementById('atelierDescription');
        const atelierDetails = document.getElementById('atelierDetails');

        atelierTitle.textContent = event.title;
        atelierDescription.textContent = event.description;

        const formattedDate = moment(event.start).format('LL');
        const formattedTime = moment(event.start).format('LT');

        const animateurs = event.extendedProps?.animateurs ?? [];
        const animateurHtml = animateurs.length
            ? animateurs.map(a => `<a href="#" class="animateur-link text-blue-600 hover:underline" data-id="${a.id}" data-nom="${a.nom_complet}">${a.nom_complet}</a>`).join(', ')
            : 'N/A';

        const campus = event.extendedProps?.campus ?? 'N/A';
        const local = event.extendedProps?.local ?? 'N/A';
        const capacite = event.extendedProps?.capacite ?? 'N/A';
        const duree = event.extendedProps?.duree ?? 'N/A';
        const url = event.extendedProps?.url ?? 'N/A';

        const urlElement = url === 'N/A'
            ? `<span>${url}</span>`
            : `<a href="${url}" target="_blank" rel="noreferrer noopener" class="text-blue-600 hover:underline">${url}</a>`;

            atelierDetails.innerHTML = `
                     <li><strong>Animateur(s):</strong> ${animateurHtml}</li>
                    </li>
                    <li><strong>Date:</strong> ${formattedDate} à ${formattedTime}</li>
                    <li><strong>Campus:</strong> ${campus}</li>
                    <li><strong>Local:</strong> ${local}</li>
                    <li><strong>Capacité:</strong> ${capacite} personnes</li>
                    <li><strong>Durée:</strong> ${duree} minutes</li>
                    <li><strong>Url inscription:</strong> ${urlElement}</li>
                `;

        const atelierId = event.extendedProps?.atelier_id ?? null;

        const btnModifier = document.getElementById('boutonModifier');
        const supprimer = document.getElementById('Supprimer');
        const messageSup = document.getElementById('deleteWarning');

        if (atelierId) {
            if (btnModifier) btnModifier.href = `/ateliers/${atelierId}/edit`;
            if (supprimer) supprimer.action = `/ateliers/${atelierId}`;
        }

        if (messageSup) {
            messageSup.textContent = "Voulez-vous vraiment supprimer cet atelier ?";
        }

        modal.classList.remove('hidden');
    }

    $('#closeModal').on('click', closeModal);
    $('#closeModalButton').on('click', closeModal);

    // Récupère les animateurs de la route puis les affiches dans le modal
    function openAnimateurModal(animateurId, animateurNom) {

        $.ajax({
            url: '/fetch-animateur-info',
            method: 'GET',
            data: { animateur_id: animateurId },
                success: function(data) {
                    $('#animateurNom').text((data.prenom && data.nom) ? data.prenom + ' ' + data.nom : 'Nom inconnu');

                    $('#animateurBio').html('<strong>Biographie :</strong> ' + (data.bio || 'Aucune biographie disponible.'));
                    $('#animateurExpertise').html('<strong>Expertise :</strong> ' + (data.expertise || 'Aucune expertise disponible.'));

                    $('#animateurModal').removeClass('hidden');
                },

            error: function() {
                alert('Impossible de charger les informations de l\'animateur.');
            }
        });
    }

    $(document).on('click', '.animateur-link', function(e) {
        e.preventDefault();
        const animateurId = $(this).data('id');
        const animateurNom = $(this).data('nom');
        openAnimateurModal(animateurId, animateurNom);
    });

    function closeModal() {
        $('#atelierModal').addClass('hidden');
    }

    $('#closeAnimateurModal').on('click', function() {
        $('#animateurModal').addClass('hidden');
    });

});
