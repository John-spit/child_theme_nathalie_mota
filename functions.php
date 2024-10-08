<?php

function nathaliemota_enqueue_scripts() {
    wp_enqueue_style('parent', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child', get_stylesheet_directory_uri() . '/assets/css/main.css', array('parent'), '1.0', 'all');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null);
    wp_enqueue_script('jquery');
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true);
    wp_enqueue_script('lightbox-js', get_stylesheet_directory_uri() . '/assets/js/lightbox.js', array('jquery'), null, true);
    wp_localize_script(
        'script',
        'load_more_photos', 
        array(
            'ajaxurl' => admin_url('admin-ajax.php'), 
            'nonce'   => wp_create_nonce('load_more_photos_nonce') 
        )
    );
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_scripts');

// Custom image sizes
function custom_image_sizes() {
    add_image_size('single-page-photo', 563, 844, true);
    add_image_size('miniature', 81, 71, true);
    add_image_size('photo-thumbnail', 546, 495, true);
    add_image_size('banner', 1440, 962, true);
}
add_action('after_setup_theme', 'custom_image_sizes');

// Requête AJAX pour charger plus de photos
function load_more_photos() {
    // Vérification nonce pour la sécurité
    check_ajax_referer('load_more_photos_nonce', 'nonce');

    // Récupération des paramètres de la requête AJAX
    $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 1;

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8, 
        'paged'          => $paged,
    );

    $photo_gallery_query = new WP_Query($args);

    if ($photo_gallery_query->have_posts()) {
        while ($photo_gallery_query->have_posts()) {
            $photo_gallery_query->the_post();
            get_template_part('templates_parts/photo-block');
        }
        wp_reset_postdata();
    } else {
        echo '<p>Plus de photos disponibles.</p>';
    }

    // Arrête l'exécution
    wp_die();
}

add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
add_action('wp_ajax_load_more_photos', 'load_more_photos');

// Requête AJAX pour filtrer les photos
function filter_photos() {
    check_ajax_referer('load_more_photos_nonce', 'nonce');

    $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 1;
    $categories = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'DESC';

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => $sort,
    );

    $tax_query = array('relation' => 'AND');

    if (!empty($categories)) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categories,
        );
    }

    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    $photo_gallery_query = new WP_Query($args);

    $response = array(
        'html' => '',
        'total_pages' => $photo_gallery_query->max_num_pages,
    );

    if ($photo_gallery_query->have_posts()) {
        ob_start();
        while ($photo_gallery_query->have_posts()) {
            $photo_gallery_query->the_post();
            get_template_part('templates_parts/photo-block');
        }
        $response['html'] = ob_get_clean();
    } else {
        $response['html'] = '<p>Plus de photos disponibles.</p>';
    }

    wp_send_json($response);
}

add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
add_action('wp_ajax_filter_photos', 'filter_photos');

?>