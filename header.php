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
        <div class="header-container">
            <div class="logo-container">
                <?php
                if (has_custom_logo()) :
                    the_custom_logo();
                else : ?>
                    <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
                <?php endif; ?>
            </div>
            <nav id="desktop">
                <?php wp_nav_menu(['theme_location' => 'main-menu',]); ?>
            </nav>
        </div>

        <div class="mobile">
            <nav class="burger">
                <input type="checkbox" id="menu" name="menu" class="m-menu__checkbox">
                <div class="m-menu__header">
                    <?php the_custom_logo(); ?>
                    <label class="m-menu__toggle" for="menu">
                      <img src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/burger.svg" alt="icone menu burger" style="width: 30px;">
                    </label>
                </div>

                <label class="m-menu__overlay"></label>

                <div class="m-menu">
                    <div class="m-menu__header">
                        <?php the_custom_logo(); ?>
                        <label class="m-menu__toggle" for="menu">
                        <img src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/close-burger.svg" alt="icone fermeture menu burger" style="width: 30px;">
                        </label>
                    </div>
                    <?php wp_nav_menu(['theme_location' => 'main-menu',]); ?>
                </div>
            </nav>
        </div>


    </header>