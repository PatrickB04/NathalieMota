<?php get_header() ?>

<div class="main-container">

    <!-- Partie image statique plus titre -->
    <section id="accueil">
        <h1 class="h1accueil">PHOTOGRAPHE EVENT</h1>
    </section>

    <!-- Partie filtres plus photos affichées dynamiquement -->
    <section id="photos-container">
        <!-- PHP pour récupérer les taxonomies catégorie et format -->
        <div class="filtres">
            <?php
            $categories = get_terms(array('taxonomy' => 'categorie', 'hide_empty' => false,));
            $formats = get_terms(array('taxonomy' => 'format', 'hide_empty' => false,));

            echo '<div class="taxonomies">';
            echo '<select name="categorie" id="categorie" class="filtrer-categorie">';
            echo '<option value="" selected disabled hidden>CATÉGORIE</option>';
            foreach ($categories as $categorie) {
                echo '<option value="' . $categorie->slug . '">' . $categorie->name . '</option>';
            }
            echo '</select>';

            echo '<select name="format" id="format" class="filtrer-format">';
            echo '<option value="" selected disabled hidden>FORMAT</option>';
            foreach ($formats as $format) {
                echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
            }
            echo '</select></div>';
            ?>

            <!-- Fenêtre pour tri par date -->
            <select name="tri_date" id="tri_date" class="filtrer-date">
                <option value="" selected disabled hidden>TRIER PAR</option>
                <option value="asc">À partir des plus anciennes</option>
                <option value="desc">À partir des plus récentes</option>
            </select>
        </div>

        <!-- PHP pour récupérer les photos -->
        <?php
        $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
        $format = isset($_POST['format']) ? $_POST['format'] : '';
        $tri_date = isset($_POST['tri_date']) ? $_POST['tri_date'] : '';

        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 8, // Limiter à 8 éléments par page
            'tax_query' => array( // Filtrer par taxonomie
                'relation' => 'AND', // Combinaison des termes
            ),
            'order' => $tri_date // Le tri par date
        );

        // Ajouter les paramètres de taxonomie seulement s'ils ne sont pas vides
        if ($categorie != '') {
            $args['tax_query'][] = array(
                'taxonomy' => 'categorie', // La taxonomie catégorie
                'field' => 'term_id', // Le champ term_id
                'terms' => $categorie // Le terme sélectionné
            );
        }

        if ($format != '') {
            $args['tax_query'][] = array(
                'taxonomy' => 'format', // La taxonomie format
                'field' => 'term_id', // Le champ term_id
                'terms' => $format // Le terme sélectionné
            );
        }

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