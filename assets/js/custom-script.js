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

// Affichage de la popup au click sur contact du menu
// document.addEventListener("DOMContentLoaded", function () {
//     let popupHidden = document.querySelector('.popup-hidden');

//     if (popupHidden) {
//         document.getElementById("menu-item-31").addEventListener("click", function () {
//             popupHidden.style.display = "flex";
//             // Récupère le formulaire à l'intérieur de .popup-body
//             let form = jQuery('.popup-body .wpcf7-form');
//             if (form.length) {
//                 // Réinitialise le formulaire CF7 (pour être sûr que le formulaire s'ouvre vierge)
//                 form[0].reset();
//             }
//         });
//     }
// });

// Affichage de la popup au click sur contact de la page single
// document.addEventListener("DOMContentLoaded", function () {
//     let popupHidden = document.querySelector('.popup-hidden');

//     if (popupHidden) {
//         document.getElementById("cta-contact").addEventListener("click", function () {
//             popupHidden.style.display = "flex";
//             // Récupère le formulaire à l'intérieur de .popup-body
//             let form = jQuery('.popup-body .wpcf7-form');
//             if (form.length) {
//                 // Réinitialise le formulaire CF7 (pour être sûr que le formulaire s'ouvre vierge)
//                 form[0].reset();
//                 $("#email").val("my-email@waytolearnx.com");
//             }
//         });
//     }
// });
// document.addEventListener("DOMContentLoaded", function () {
//     let popupHidden = document.querySelector('.popup-hidden');

//     if (popupHidden) {
//         document.getElementById("cta-contact").addEventListener("click", function () {
//             popupHidden.style.display = "flex";
//             // Récupère le formulaire à l'intérieur de .popup-body
//             let form = jQuery('.popup-body .wpcf7-form');
//             if (form.length) {
//                 // Réinitialise le formulaire CF7 (pour être sûr que le formulaire s'ouvre vierge)
//                 form[0].reset();
//                 jQuery("#reference").val('toto');
//             }
//         });
//     }
// });
document.addEventListener("DOMContentLoaded", function () {
    let popupHidden = document.querySelector('.popup-hidden');
    let ctaContact = document.getElementById("cta-contact");
    let menuItem31 = document.getElementById("menu-item-31");

    if (popupHidden) {
        if (menuItem31) {
            menuItem31.addEventListener("click", function () {
                popupHidden.style.display = "flex";
                // Récupère le formulaire à l'intérieur de .popup-body
                let form = jQuery('.popup-body .wpcf7-form');
                if (form.length) {
                    // Réinitialise le formulaire CF7 (pour être sûr que le formulaire s'ouvre vierge)
                    form[0].reset();
                }
            });
        }

        if (ctaContact) {
            ctaContact.addEventListener("click", function () {
                popupHidden.style.display = "flex";
                // Récupère le formulaire à l'intérieur de .popup-body
                let form = jQuery('.popup-body .wpcf7-form');
                if (form.length) {
                    // Réinitialise le formulaire CF7 (pour être sûr que le formulaire s'ouvre vierge)
                    form[0].reset();
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



/************************************ Gestion du bouton "afficher plus" ************************************/
jQuery(document).ready(function($) {
    var ajaxurl = my_ajax_object.ajax_url;
    var page = 2; // Initialiser la page à 2 pour charger les éléments suivants
    var totalItems = 0; // Initialiser totalItems à 0
    var remainingItems = 0; // Initialiser remainingItems à 0

    // Faire une requête AJAX pour obtenir le nombre total d'articles du CPT "photo"
    $.ajax({
        url: ajaxurl,
        type: 'post',
        data: {
            action: 'get_total_photos',
        },
        success: function(response) {
            totalItems = parseInt(response); // Mettre à jour totalItems avec la réponse du serveur
            remainingItems = totalItems - 8; // Enlever 8 de ce nombre
// console.log('Nombre total de photos: ',totalItems);
// console.log('Photos restantes au tout début ajax: ',remainingItems);
            // Cacher le bouton si tous les éléments sont déjà chargés
            if (remainingItems <= 0) {
                $('#load-more').hide();
            }
        }
    });

    // Prise en compte des filtres 
    $('#categorie, #format, #tri_date').on('change', function() {
        var categorie = $('#categorie').val();
        var format = $('#format').val();
        var tri_date = $('#tri_date').val();
// console.log('catégorie: ',categorie);
// console.log('format: ',format);
// console.log('tri date : ',tri_date);
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'load_more_photos',
                page: 1, // Commencez à la première page
                categorie: categorie,
                format: format,
                tri_date: tri_date
            },
            success: function(response) {
                var sousChaine = "<img";
                var occurrences = response.split(sousChaine).length - 1;

// console.log('Nombre d\'occurrences de "' + sousChaine + '" : ', occurrences);
// console.log('Photos restantes début de la boucle filtre: ',remainingItems);

                if ($('#photos').length) { // Vérifie si #photos existe
                    // alert('La balise #photos existe dans le DOM.');
                    $('#photos').html(response);
                } 
                else 
                {
                    alert('La balise #photos n\'existe pas dans le DOM.');
                }
                if (occurrences !== 8) {
                    // console.log('Photos restantes après occurrences de la boucle filtre: ',remainingItems);
                    var remainingItems = occurrences - 8; 
                    if (remainingItems <= 0) {
                        $('#load-more').hide();
                    } else {
                        $('#load-more').show();
                    }
                }
                
                page = 2;
            }
        });
    });
        
    
    $('#load-more').on('click', function() {
        var categorie = $('#categorie').val();
        var format = $('#format').val();
        var tri_date = $('#tri_date').val();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'load_more_photos',
                page: page,
                categorie: categorie,
                format: format,
                tri_date: tri_date
            },
            success: function(response) {
                if (response.trim() == '') {
                    $('#load-more').hide();
                } else {
                    $('#photos').append(response);
                    page++;
                    remainingItems -= 8;
// console.log('Photos restantes: ',remainingItems);
                    if (remainingItems <= 0) {
                        $('#load-more').hide();

                    }
                }
            }
        });
    });
});

/******************** Miniature avec flèches de navigation page SINGLE ******************************************/
jQuery(document).ready(function($) {
    let postIds = my_ajax_object.post_ids;
    let position = parseInt(my_ajax_object.position);
    let curIndex = 0;

    // Lors du survol de la flèche de droite, charge la miniature du post suivant
    $('#next-post').mouseenter(function() {
        curIndex = (position + 1) % postIds.length;
        loadPostThumbnail(postIds[curIndex]);
    });

    // Lors du survol de la flèche de gauche, charge la miniature du post précédent
    $('#previous-post').mouseenter(function() {
        curIndex = (position - 1 + postIds.length) % postIds.length;
        loadPostThumbnail(postIds[curIndex]);
    });

    // Lorsque la souris quitte la flèche, l'espace de la miniature reste vide
    $('.single-commande-fleche').mouseleave(function() {
        $('#post-thumbnail').empty();
    });

    // Lors du clic sur la flèche, redirige vers la page du post correspondant
    $('.single-commande-fleche').click(function(e) {
        e.preventDefault();
        window.location.href = $(this).data('url');
    });

    function loadPostThumbnail(postId) {
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_post_thumbnail',
                post_id: postId
            },
            success: function(result) {
                let data = JSON.parse(result);
                // Met à jour la miniature du post avec le résultat de la requête AJAX
                $('#post-thumbnail').html(data.thumbnail);
                // Stocke l'URL du post dans un attribut de données
                $('.single-commande-fleche').data('url', data.url);
            }
        });
    }
});

/******************** Lightbox ******************************************/
document.addEventListener("DOMContentLoaded", function() {
    lightbox.option({
      'alwaysShowNavOnTouchDevices': true,
      'showImageNumberLabel': false,
      'wrapAround': true,
      'resizeDuration': 200
    })
  });
  