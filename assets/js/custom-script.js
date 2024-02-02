/************************************ Comportement de la modale ************************************/
// Attend que le document HTML soit entièrement chargé
document.addEventListener('DOMContentLoaded', function () {

    // Récupère le modal
    let modal = document.getElementById('myModal');

    // Récupère le bouton qui ouvre le modal
    let btn = document.getElementById("menu-item-31");

    // Récupère l'élément <span> qui ferme le modal
    let span = document.getElementsByClassName("close")[0];

    // Lorsque l'utilisateur clique sur le bouton, ouvre le modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // Lorsque l'utilisateur clique sur ENVOYER, si OK ferme la fenêtre
    document.addEventListener('wpcf7mailsent', function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        } false ;
    });
});