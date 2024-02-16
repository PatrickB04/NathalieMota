<?php

// Enregistrer les styles du thème
function NathalieMota_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'NathalieMota_enqueue_styles');


// Enregistrer le script personnalisé du thème
function enqueue_custom_script() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', array('jquery'), '1.0.0', true);
    wp_localize_script('custom-script', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
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

    // Enregistrez les arguments de la requête dans le fichier de journalisation des erreurs
    error_log('Arguments de la requête : ' . print_r($args, true));

    $query = new WP_Query($args);

    // Enregistrez le nombre de publications trouvées dans le fichier de journalisation des erreurs
    error_log('Nombre de publications trouvées : ' . $query->found_posts);

    while ($query->have_posts()) {
        $query->the_post();
        if (has_post_thumbnail()) {
            the_post_thumbnail('taille_personnalisee', array('class' => 'image-personnalisee'));
        }

        // Enregistrez le titre de la publication dans le fichier de journalisation des erreurs
        error_log('Titre de la publication : ' . get_the_title());
    }
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
