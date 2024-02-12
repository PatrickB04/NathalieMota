<?php

/* Prise en charge du style NathalieMota */
function NathalieMota_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'NathalieMota_enqueue_styles');


/* Prise en charge du script JavaScript */
// function enqueue_custom_script() {
//     wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', '1.0.0', true);
// }
// add_action('wp_enqueue_scripts', 'enqueue_custom_script');
function enqueue_custom_script() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', array('jquery'), '1.0.0', true); // Rajout de JQUERY

    // Passer la valeur de ajaxurl de PHP à JavaScript
    wp_localize_script('custom-script', 'ajaxurl', admin_url('admin-ajax.php')); // Pour pouvoir utiliser AJAXURL
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');




/* Permet d'inclure les menus principal et secondaire pour le header et le footer */
function register_my_menu() {
    register_nav_menu('main-menu', __('Menu principal', 'text-domain'));
    register_nav_menu('secondary-menu', __('Menu secondaire', 'text-domain'));
}
add_action('after_setup_theme', 'register_my_menu');


/* Permet de gérer le logo dans administration>Personnalisez>Identité du site */
add_theme_support('custom-logo');


/* Autoriser le téléversement de fichiers SVG pour le logo
function allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');    -----------------------> mis en commentaire pour des raisons de sécurité  */


// Ajout d'une taille personnalisée pour les photos de la page principale
add_image_size( 'taille_personnalisee', 564, 495, true ); // 564px de large, 495px de haut, troncature forcée


// Gestion du "Afficher plus" de la page d'accueil
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

function load_more_photos() {
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $_POST['page'],
    );

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            if ( has_post_thumbnail() ) {
                the_post_thumbnail('taille_personnalisee', array( 'class' => 'image-personnalisee' ));
            }
        }
        wp_reset_postdata();
    }

    die();
}
