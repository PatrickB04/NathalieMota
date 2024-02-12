<?php get_header() ?>

<div class="main-container">

    <!-- Partie image statique plus titre -->
    <section id="accueil">
        <h1 class="h1accueil">PHOTOGRAPHE EVENT</h1>
    </section>

    <!-- Partie filtres plus photos affichées dynamiquement -->
    <section id="photos-container">
        <h2>position des filtres</h2>

        <!-- PHP pour récupérer les photos -->
        <?php
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 8, // Limiter à 8 éléments par page
        );
        // La requête
        $the_query = new WP_Query($args);
        // La boucle
        if ($the_query->have_posts()) {
            echo '<div id="photos">';
            while ($the_query->have_posts()) {
                $the_query->the_post();
                // Vérifie si l'article a une image mise en avant
                if (has_post_thumbnail()) {
                    // Affiche l'image mise en avant avec la taille personnalisée et une classe
                    the_post_thumbnail('taille_personnalisee', array('class' => 'image-personnalisee'));
                }
            }
            echo '</div>';
            echo '<button id="load-more">Charger plus</button>';
            /* Réinitialise les données de publication après une requête secondaire. */
            wp_reset_postdata();
        }
        ?>
    </section>
</div>
</main>

<?php get_footer() ?>