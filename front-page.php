<?php
// Récupérer une image aléatoire du type de contenu personnalisé "photo"
$args = array(
    'post_type'      => 'photo',
    'posts_per_page' => 1, 
    'orderby'        => 'rand', 
);

$random_photo_query = new WP_Query( $args );

if ( $random_photo_query->have_posts() ) {
    $random_photo_query->the_post();
    $background_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); 
    wp_reset_postdata(); // Réinitialiser les données post après la première requête
}

get_header();
?>

<div class="page-content">
    <div class="hero-header" style="background-image: url('<?php echo esc_url( $background_image_url ); ?>');">
        <h1>PHOTOGRAPHE EVENT</h1>
    </div>

    <section class="photo-gallery">

        <div class="gallery">
            <?php
            // Paramètres de la requête WP_Query pour la galerie
            $args = array(
                'post_type'      => 'photo', 
                'posts_per_page' => 8,
            );

            // Nouvelle requête WP_Query pour la galerie
            $photo_gallery_query = new WP_Query( $args );

            if ( $photo_gallery_query->have_posts() ) {
                while ( $photo_gallery_query->have_posts() ) {
                    $photo_gallery_query->the_post();
                    
                    get_template_part( 'templates_parts/photo-block' );
                }

                // Réinitialiser les données post
                wp_reset_postdata();
            } else {
                echo '<p>Aucune photo trouvée.</p>';
            }
            ?>
        </div>
            <!-- Conteneur pour les nouvelles photos -->
    <div id="new-photos"></div>

<!-- Bouton pour charger plus -->
<button id="load-more" data-page="1" data-max-pages="<?php echo $photo_gallery_query->max_num_pages; ?>">
    Charger plus
</button>
    </section>
</div>

<?php
get_footer();
?>