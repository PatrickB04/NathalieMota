<footer>
    <?php // Affiche le menu "Menu secondaire" enregistré au préalable.
    wp_nav_menu(['theme_location' => 'secondary-menu',]);
    ?>
</footer>

<!-- Insertion de la template pour l'affichage de la modale -->
<section><?php get_template_part( '/template-parts/modale' ); ?></section>

</body>
</html>