<?php

function nathaliemota_enqueue_scripts() {
    wp_enqueue_style('parent', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child', get_stylesheet_directory_uri() . '/assets/css/main.css', array('parent'), '1.0', 'all');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null);
    wp_enqueue_script('jquery');
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_scripts');
