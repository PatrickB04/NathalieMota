<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

    <title>
        <?php // Affiche le titre du site
        echo esc_html(get_bloginfo('name')); ?>
    </title>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
    <header>
        <?php       // Affiche le logo
        if (has_custom_logo()) :
            the_custom_logo();
        else : ?>
            <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
        <?php endif; ?>
        <nav>
            <?php   // Affiche le menu "Menu principal" enregistré au préalable dans l'admin WP.
            wp_nav_menu(['theme_location' => 'main-menu',]); ?>
        </nav>
    </header>