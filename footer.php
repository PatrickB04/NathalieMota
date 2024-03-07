<?php wp_footer(); ?>
<footer>
    <div class="footer-align">
        <?php // Affiche le menu "Menu secondaire" enregistré au préalable.
        wp_nav_menu(['theme_location' => 'secondary-menu',]);
        ?>
        <div class="maj copyright">tous droits réservés</div>
    </div>
</footer>

<!-- Insertion de la template pour l'affichage de la modale -->
<section class="popup-hidden"><?php get_template_part('/template-parts/modale'); ?></section>

</body>

</html>