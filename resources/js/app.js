import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * @author John Sebastian Zuleta Franco
 */
document.addEventListener('DOMContentLoaded', () => {
    // Toggle des détails utilisateur
    const toggles = document.querySelectorAll('.toggle-user-details');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const userId = toggle.getAttribute('data-user-id');
            const details = document.getElementById(`details-${userId}`);
            const arrow = document.getElementById(`arrow-${userId}`);

            details.classList.toggle('hidden');
            arrow.textContent = details.classList.contains('hidden') ? '▼' : '▲';
        });
    });
});

// Ouvrir modale
window.openRoleModal = function (userId, userRole) {
    document.getElementById('modalUserId').value = userId;
    document.getElementById('modalUserRole').value = userRole;
    document.getElementById('roleModal').classList.remove('hidden');
}

// Fermer modale
window.closeRoleModal = function () {
    document.getElementById('roleModal').classList.add('hidden');
}


