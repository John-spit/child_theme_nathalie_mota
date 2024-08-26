<?php
/**
 * The template for displaying all single posts of type "photo"
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

while ( have_posts() ) :
	the_post();

	?>

	<div class="single-photo-page">
		<section class="single-photo-container">

			<div class="photo-meta-container">
				<div class="photo-meta">
					<h1><?php the_title(); ?></h1>    
					<p>Référence : <span id="photoReference"><?php echo get_post_meta( get_the_ID(), 'reference', true ); ?></span></p>
					<p>Catégorie : <?php echo get_the_term_list( get_the_ID(), 'categorie', '', ', ' ); ?></p>
					<p>Format : <?php echo get_the_term_list( get_the_ID(), 'format', '', ', ' ); ?></p>
					<p>Type : <?php echo get_post_meta( get_the_ID(), 'type', true ); ?></p>
					<p>Année : <?php echo get_the_date('Y'); ?></p>
					<div class="separator separator-meta"></div>
				</div>
				<div class="photo-content">
					<?php the_content(); ?>
				</div>			
			</div>

			<div class="contact-single-container">
				<div class="contact-container">
					<p>Cette photo vous intéresse ?</p>
					<button id="photoContactBtn" class="photo-meta-contactBtn">Contact</button>
				</div>
				
				<!-- Navigation circulaire -->
				<?php
// Récupère le post précédent et suivant, peu importe la catégorie
$prev_post = get_previous_post();
$next_post = get_next_post();

// Si nous ne trouvons pas de post précédent ou suivant, bouclez au début/fin
if ( ! $prev_post ) {
    $prev_post = get_posts( array(
        'post_type'      => 'photo',
        'posts_per_page' => 1,
        'order'          => 'DESC',
    ) )[0];
}

if ( ! $next_post ) {
    $next_post = get_posts( array(
        'post_type'      => 'photo',
        'posts_per_page' => 1,
        'order'          => 'ASC',
    ) )[0];
}
?>

<div class="navigation-wrapper">
    <?php if ( $prev_post ) : ?>
        <div class="nav-previous">
            <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-left.png" alt="Précédent">
            </a>
            <?php 
            $prev_thumbnail_url = get_the_post_thumbnail_url( $prev_post->ID, 'thumbnail' );
            if ( $prev_thumbnail_url ) : ?>
                <div class="previous-thumbnail thumbnail">
                    <img src="<?php echo esc_url( $prev_thumbnail_url ); ?>" alt="Photo précédente">
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ( $next_post ) : ?>
        <div class="nav-next">
            <a href="<?php echo get_permalink( $next_post->ID ); ?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-right.png" alt="Suivant">
            </a>
            <?php 
            $next_thumbnail_url = get_the_post_thumbnail_url( $next_post->ID, 'thumbnail' );
            if ( $next_thumbnail_url ) : ?>
                <div class="next-thumbnail thumbnail">
                    <img src="<?php echo esc_url( $next_thumbnail_url ); ?>" alt="Photo suivante">
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
			</div>
			<div class="separator"></div>

		</section>

		<section class="like-also">
    <p>VOUS AIMEREZ AUSSI</p>
    
		<div class="related-photos">
    <?php
    // Récupère les catégories du post en cours
    $categories = get_the_terms( get_the_ID(), 'categorie' );

    if ( $categories && ! is_wp_error( $categories ) ) {
        $category_ids = wp_list_pluck( $categories, 'term_id' );

        // Configure la requête pour obtenir deux photos aléatoires de la même catégorie
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 2, 
            'post__not_in' => array( get_the_ID() ),
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'term_id',
                    'terms'    => $category_ids,
                ),
            ),
        );

        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            global $wp_query;
            $wp_query_backup = $wp_query; // Sauvegarde la requête principale
            $wp_query = $query;
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                get_template_part('templates_parts/photo-block');  // Affiche chaque photo
            }
            $wp_query = $wp_query_backup; // Restaure la requête principale
            wp_reset_postdata();
        }
    }
    ?>
		</div>
</section>
	</div>
	<?php

	
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}

endwhile; 

get_footer();