<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/Logo.png'; ?>" alt="Logo Nathalie Mota">
                </a>
            </div>
            <div class="menu-container">
                <div class="nav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'nav-menu',
                    ));
                    ?>
                </div>
                <div class="contact-btn">
                    <p id="contactBtn">Contact</p>
                </div>
            </div>
        </div>
    </header>
