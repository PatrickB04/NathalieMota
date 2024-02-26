<?php

// Enregistrer les styles du thème
function NathalieMota_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('lightbox-style', get_template_directory_uri() . '/css/lightbox.css');
}
add_action('wp_enqueue_scripts', 'NathalieMota_enqueue_styles');


// Enregistrer le script personnalisé du thème
function enqueue_custom_script() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('lightbox-plus-jquery', get_template_directory_uri() . '/assets/js/lightbox-plus-jquery.js', array('jquery'), '1.0.0', true); // script Lightbox

    wp_localize_script('custom-script', 'my_ajax_object', array( // Tableau de tous les objets PHP qui sont passé à AJAX
        'ajax_url' => admin_url('admin-ajax.php'),
        'current_post_id' => get_the_ID(),
        'next_post_id' => get_next_post() ? get_next_post()->ID : null,
        'previous_post_id' => get_previous_post() ? get_previous_post()->ID : null,
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');


// Enregistrer les menus du thème
function register_my_menu() {
    register_nav_menu('main-menu', __('Menu principal', 'text-domain'));
    register_nav_menu('secondary-menu', __('Menu secondaire', 'text-domain'));
}
add_action('after_setup_theme', 'register_my_menu');


// Ajouter le support du logo personnalisé
add_theme_support('custom-logo');


// Définir la taille personnalisée des images
function add_custom_image_size() {
    add_image_size('taille_personnalisee', 564, 495, true);
}
add_action('after_setup_theme', 'add_custom_image_size');


// Créer la fonction pour obtenir le nombre total de photos
function get_total_photos() {
    $count_posts = wp_count_posts('photo');
    echo $count_posts->publish;
    wp_die();
}
add_action('wp_ajax_get_total_photos', 'get_total_photos');
add_action('wp_ajax_nopriv_get_total_photos', 'get_total_photos');


// Gestion du "Afficher plus" de la page d'accueil
function load_more_photos() {
    $paged = $_POST['page'];
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $tri_date = isset($_POST['tri_date']) ? $_POST['tri_date'] : '';

    // Enregistrez les valeurs dans le fichier de journalisation des erreurs
    error_log('Page: ' . $paged);
    error_log('Catégorie: ' . $categorie);
    error_log('Format: ' . $format);
    error_log('Tri par date: ' . $tri_date);

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'tax_query' => array(
            'relation' => 'AND',
        ),
        'order' => $tri_date
    );

    if ($categorie != '') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie
        );
    }

    if ($format != '') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format
        );
    }

    // Enregistre les arguments de la requête dans le fichier de journalisation des erreurs
    error_log('Arguments de la requête : ' . print_r($args, true));

    $query = new WP_Query($args);

    // Enregistre le nombre de publications trouvées dans le fichier de journalisation des erreurs
    error_log('Nombre de publications trouvées : ' . $query->found_posts);

    while ($query->have_posts()) {
        $query->the_post();
        if (has_post_thumbnail()) {

            // Récupérer l'ID de l'image mise en avant
            $post_thumbnail_id = get_post_thumbnail_id();
            // Récupérer l'URL de l'image originale
            $image_url = wp_get_attachment_url($post_thumbnail_id);
                
                
            // Affiche l'image mise en avant avec la taille personnalisée et une classe + tout ce qui concerne l'effet survol
            echo '<div class="portfolio-item">';
            the_post_thumbnail('taille_personnalisee', array('class' => 'image-personnalisee'));
            echo '<div class="overlay">'; // Effet survol
            echo '<div class="symbol"><a href="' . get_permalink() . '"><img src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/Icon_eye.svg" alt="Icon_eye"></a></div>'; // Oeil central
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
            echo '<div class="icon"><a class="example-image-link" href="' . $image_url . '" data-lightbox="NathalieMota" data-title="<div>' . strtoupper($reference) . '</div><div>' . strtoupper($category->name) . '</div>"><img src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/Icon_fullscreen.svg" alt="Full_screen"></a></div></div></div>'; // lightbox
            echo '</div>';
        }
// Enregistrez le titre de la publication dans le fichier de journalisation des erreurs
// error_log('Titre de la publication : ' . get_the_title());
    }
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// Pour la gestion des miniatures de la page SINGLE
function get_post_thumbnail() {
    $post_id = $_POST['post_id'];
    $thumbnail_url = get_the_post_thumbnail_url($post_id);
    $permalink = get_permalink($post_id);
    echo json_encode(array('thumbnail' => '<a href="' . $permalink . '"><img src="' . $thumbnail_url . '" width="90"></a>', 'url' => $permalink));
    wp_die();
}
add_action('wp_ajax_get_post_thumbnail', 'get_post_thumbnail');
add_action('wp_ajax_nopriv_get_post_thumbnail', 'get_post_thumbnail');


/********************* Gestion de la navigation sur la miniature *********************** */
function script_array_id() {
    // Récupère tous les posts de type 'photo'
    $posts = get_posts(array(
        'post_type' => 'photo',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
    ));

    $actual_post_img = get_the_ID();
    error_log($actual_post_img);

    // Crée un tableau d'ID de posts
    $post_ids = array_map(function($post) {
        return $post->ID;
    }, $posts);

    $position = array_search($actual_post_img, $post_ids);
    error_log($position);

    // Enqueue du script custom-script.js
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', array('jquery'), '1.0', true);

    // Passe les ID de posts au script
    wp_localize_script('custom-script', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'post_ids' => $post_ids,
        'position' => $position,
    ));
}
add_action('wp_enqueue_scripts', 'script_array_id');

/***************************** Affichage aléatoire des photos de la partie vous aimerez *************/
function get_related_posts($post_id, $number_of_posts = 2) {
    $categories = wp_get_post_terms($post_id, 'categorie', array('fields' => 'ids'));
    $args = array(
        'post_type' => 'photo',
        'post_status' => 'publish',
        'posts_per_page' => $number_of_posts,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'term_id',
                'terms' => $categories,
            )
        ),
        'post__not_in' => array($post_id),
        'orderby' => 'rand'
    );
    return get_posts($args);
}

