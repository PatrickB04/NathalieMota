<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php // Affiche le titre du site
        echo esc_html(get_bloginfo('name')); ?>
    </title>
    <?php wp_head(); ?>
</head>

<body>
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