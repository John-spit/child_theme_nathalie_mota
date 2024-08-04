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

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	// Custom code to display photo details
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
				$args = array(
					'post_type'      => 'photo',
					'posts_per_page' => -1,  
				);

				$all_photos = get_posts( $args );
				$total_photos = count( $all_photos );
				$current_index = array_search( get_the_ID(), wp_list_pluck( $all_photos, 'ID' ) );

				$prev_index = ( $current_index - 1 + $total_photos ) % $total_photos;
				$next_index = ( $current_index + 1 ) % $total_photos;

				$prev_post = $all_photos[ $prev_index ];
				$next_post = $all_photos[ $next_index ];
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
			
			<?php get_template_part('templates_parts/photo-block'); ?>
		</section>
	</div>
	<?php

	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}

endwhile; // End of the loop.

get_footer();