/************************************ Comportement de la modale ************************************/
// Lorsque l'utilisateur clique sur (x), ferme le modal
document.addEventListener('DOMContentLoaded', function() {
    var closeButtons = document.querySelectorAll('.popup-close');

    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var hidden = document.querySelector('.popup-hidden');
            if (hidden) {
                hidden.style.display = 'none';
            }
        });
    });
});

// Affichage de la popup au click sur contact
document.addEventListener("DOMContentLoaded", function () {
    let popupHidden = document.querySelector('.popup-hidden');

    if (popupHidden) {
        document.getElementById("menu-item-31").addEventListener("click", function () {
            popupHidden.style.display = "flex";
        });
    }
});

// Fermeture de la fenêtre popup à l'envoi du formulaire
document.addEventListener('wpcf7mailsent', function(event) {
    let element = document.querySelector('.popup-hidden');
    if (element) {
        element.style.display = "none";
    }
}, false);
