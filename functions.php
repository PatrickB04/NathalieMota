<?php

/* Prise en charge du style NathalieMota */
function NathalieMota_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'NathalieMota_enqueue_styles');


/* Prise en charge du script JavaScript */
function enqueue_custom_script() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', '1.0.0', true);
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
add_filter('upload_mimes', 'allow_svg_upload');          --> mis en commentaire pour des raisons de sécurité  */

?>