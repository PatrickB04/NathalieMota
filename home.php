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
            echo '<div class="custom-select">';
            echo '<select name="categorie" id="categorie" class="filtrer-categorie">';
            echo '<option value="" selected disabled hidden>CATÉGORIE</option>';
            foreach ($categories as $categorie) {
                echo '<option value="' . $categorie->slug . '">' . $categorie->name . '</option>';
            }
            echo '</select></div>';
            echo '<div class="custom-select">';
            echo '<select name="format" id="format" class="filtrer-format">';
            echo '<option value="" selected disabled hidden>FORMAT</option>';
            foreach ($formats as $format) {
                echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
            }
            echo '</select></div></div>';
            ?>

            <!-- Fenêtre pour tri par date -->
            <div class="custom-select">
            <select name="tri_date" id="tri_date" class="filtrer-date">
                <option value="" selected disabled hidden>TRIER PAR</option>
                <option value="asc">À partir des plus anciennes</option>
                <option value="desc">À partir des plus récentes</option>
            </select>
            </div>
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
                // Récupérer l'ID de l'image mise en avant
                $post_thumbnail_id = get_post_thumbnail_id();
                // Récupérer l'URL de l'image originale
                $image_url = wp_get_attachment_url($post_thumbnail_id);

                    // Affiche l'image mise en avant avec la taille personnalisée et une classe + tout ce qui concerne l'effet survol
                    echo '<div class="portfolio-item">';
                    the_post_thumbnail('taille_personnalisee', array('class' => 'image-personnalisee'));

                    echo '<div class="overlay">'; // Effet survol
                    echo '<div class="symbol"><a href="' . get_permalink() . '"><img src="'.get_template_directory_uri() .'/assets/images/Icon_eye.svg" alt="Icon_eye"></a></div>'; // Oeil central
                    $reference = get_field('reference'); // Récupération de la référence
                    echo '<div class="reference">' . $reference . '</div>';  // Affichage de la référence
                    $categories = get_the_terms(get_the_ID(), 'categorie'); // Récupération de la catégorie
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            echo '<div class="category">' . $category->name . '</div>'; // Affichage de la catégorie
                        }
                    }
                    else
                    {
                        echo '<div class="category">Pas de catégorie</div>'; // Affichage du message en cas de catégorie non définie

                    }
                    echo '<div class="icon"><a class="example-image-link" href="' . $image_url . '" data-lightbox="NathalieMota" data-title="<div>' . strtoupper($reference) . '</div><div>' . strtoupper($category->name) . '</div>"><img src="'.get_template_directory_uri() .'/assets/images/Icon_fullscreen.svg" alt="Full_screen"></a></div></div></div>'; // lightbox
                }
            }
            echo '</div>';
            echo '<button id="load-more">Charger plus</button>';
            wp_reset_postdata();
        }
        ?>
    </section>
</div>
</main>

<?php get_footer() ?>