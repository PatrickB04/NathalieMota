/************************************ Gestion du bouton "afficher plus" ************************************/
jQuery(document).ready(function($) {
    let ajaxurl = my_ajax_object.ajax_url;
    let page = 2;
    let totalItems = 0;
    let remainingItems = 0;

    $.ajax({
        url: ajaxurl,
        type: 'post',
        data: {
            action: 'get_total_photos',
        },
        success: function(response) {
            totalItems = parseInt(response); // Mettre à jour totalItems avec la réponse du serveur
            remainingItems = totalItems - 8; // Enlever 8 de ce nombre
            if (remainingItems <= 0) {
                $('#load-more').hide();
            }
        }
    });

    // Prise en compte des filtres 
    $('#categorie, #format, #tri_date').on('change', function() {
        let categorie = $('#categorie').val();
        let format = $('#format').val();
        let tri_date = $('#tri_date').val();

        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'load_more_photos',
                page: 1,
                categorie: categorie,
                format: format,
                tri_date: tri_date
            },
            success: function(response) {
                let sousChaine = "<img";
                let occurrences = response.split(sousChaine).length - 1;

                if ($('#photos').length) {
                    $('#photos').html(response);
                } 
                else 
                {
                    alert('La balise #photos n\'existe pas dans le DOM.');
                }
                if (occurrences !== 8) {
                    remainingItems = occurrences - 8; 
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
        let categorie = $('#categorie').val();
        let format = $('#format').val();
        let tri_date = $('#tri_date').val();
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
                    if (remainingItems <= 0) {
                        $('#load-more').hide();

                    }
                }
            }
        });
    });
});

/*************************************** Miniature avec flèches de navigation page SINGLE ******************************************/
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

/********************************************** Options de Lightbox2 ********************************************************************/
document.addEventListener("DOMContentLoaded", function() {
    lightbox.option({
      'alwaysShowNavOnTouchDevices': true,
      'showImageNumberLabel': false,
      'wrapAround': true,
      'resizeDuration': 200
    })
});
  
/********************************************** Menu Burger *******************************************************************************/
  // Sélectionne la case à cocher
let checkbox = document.getElementById("menu");

// Ajoute un écouteur d'événements pour détecter les changements d'état de la case à cocher
checkbox.addEventListener('change', function() {
  let menu = document.querySelector('.m-menu');
  let overlay = document.querySelector('.m-menu__overlay')
  
  // Vérifie si la case à cocher est cochée ou non
  if (this.checked) {
    // Ajoute la classe "active" lorsque la case est cochée
    menu.classList.add('active');
    overlay.classList.add('active')
  } else {
    // Supprime la classe "active" lorsque la case est décochée
    menu.classList.remove('active');
    overlay.classList.remove('active');
  }
});


/********************************* Personnalisation des filtres  avec la méthode W3School *****************************************************/
document.addEventListener("DOMContentLoaded", function() {
let x, i, j, l, ll, selElmnt, a, b, c;

let tri_date = "", categorie = "", format = "", page ="", occurrences = 0; // Déclaration des variables ici pour qu'elles gardent leur valeur à chaque clic

/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        let y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
        /********************** Rajout Nathalie Mota *************************/      
        let selectedType = s.id;

        // Récupère la valeur correspondante en fonction du type de sélection
        if (selectedType === "tri_date") {
            tri_date = s.options[s.selectedIndex].value;
            console.log("Tri par date: " + tri_date);
        } else if (selectedType === "categorie") {
            categorie = s.options[s.selectedIndex].value;
            console.log("Catégorie: " + categorie);
        } else if (selectedType === "format") {
            format = s.options[s.selectedIndex].value;
            console.log("Format: " + format);
        }
        let ajaxurl = my_ajax_object.ajax_url;

        // Nouvelle action AJAX pour récupérer le nombre de photos filtrées
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'get_total_photos_filtres',
                page: 1,
                categorie: categorie,
                format: format,
                tri_date: tri_date
            },
            success: function(response) {
                occurrences = parseInt(response);
                console.log('Nombre total de photos :', occurrences);

                load_more_photos(occurrences, categorie, format, tri_date);
            },
            error: function(error) {
                console.error(error);
            }
        });

        // Nouvelle action AJAX pour charger les photos filtrées
        function load_more_photos(occurrences, categorie, format, tri_date) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_photos',
                    page: page,
                    categorie: categorie,
                    format: format,
                    tri_date: tri_date,
                    occurrences: occurrences
                },
                success: function(response) {
                    if ($('#photos').length) {
                        $('#photos').html(response);
                    } else {
                        alert('La balise #photos n\'existe pas dans le DOM.');
                    }

                    occurrences = occurrences - 8;
                    console.log('occurrences avant clic : ', occurrences)

                    if (occurrences <= 0) {
                        $('#load-more').hide();
                    } else {
                        $('#load-more').show();
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });

            // Charger plus de photos filtrées
            $('#load-more').on('click', function() {
                occurrences = occurrences - 8;
                console.log('occurrences après clic : ', occurrences)
    
                if (occurrences <= 0) {
                    $('#load-more').hide();
                } else {
                    $('#load-more').show();
                }
                page++;
            });    
        }
        /********************** Fin du rajout Nathalie Mota *************************/

    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}
});

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  let x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);
