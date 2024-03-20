/************************************ Comportement de la modale ************************************/
// Lorsque l'utilisateur clique sur (x), ferme le modal
document.addEventListener('DOMContentLoaded', function() {
    let closeButtons = document.querySelectorAll('.popup-close');

    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let hidden = document.querySelector('.popup-hidden');
            if (hidden) {
                hidden.style.display = 'none';
            }
        });
    });
});

// Les différents modes d'ouverture de la modale : click sur "Contact" du menu principal, du menu burger ou du CTA
document.addEventListener("DOMContentLoaded", function () {
    let popupHidden = document.querySelector('.popup-hidden');
    let ctaContact = document.getElementById("cta-contact");
    let menuItem31 = document.getElementById("menu-item-31");
    let menuItem31Class = document.querySelector('#menu-menu-principal-1 .menu-item-31');

    if (popupHidden) {
        if (menuItem31) { // Click sur contact menu principal
            menuItem31.addEventListener("click", function () {
                popupHidden.style.display = "flex";
                // Récupère le formulaire à l'intérieur de .popup-body
                let form = jQuery('.popup-body .wpcf7-form');
                if (form.length) {
                    form[0].reset();
                }
            });
        }

        if (menuItem31Class) { // Click sur contact menu burger
            menuItem31Class.addEventListener("click", function () {
                popupHidden.style.display = "flex";
                let form = jQuery('.popup-body .wpcf7-form');
                if (form.length) {
                    form[0].reset();
                }
            });
        }

        if (ctaContact) { // Click sur contact de la page single (récupère la référence en cours)
            ctaContact.addEventListener("click", function () {
                popupHidden.style.display = "flex";
                let form = jQuery('.popup-body .wpcf7-form');
                if (form.length) {
                    form[0].reset();
                    // Récupère la référence pour l'ajouter au formulaire
                    let reference = this.getAttribute('data-reference');
                    jQuery("#reference").val(reference);
                }
            });
        }
    }
});


// Fermeture de la fenêtre popup à l'envoi du formulaire
document.addEventListener('wpcf7mailsent', function() {
    let element = document.querySelector('.popup-hidden');
    if (element) {
        element.style.display = "none";
    }
}, false);



