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
	<div class="single-photo-container">
		<div class="photo-meta-container">
			<div class="photo-meta">
						<h1><?php the_title(); ?></h1>    
						<p>Référence : <span id="photoReference"><?php echo get_post_meta( get_the_ID(), 'reference', true ); ?></span></p>
						<p>Catégorie : <?php echo get_the_term_list( get_the_ID(), 'categorie', '', ', ' ); ?></p>
						<p>Format : <?php echo get_the_term_list( get_the_ID(), 'format', '', ', ' ); ?></p>
						<p>Type : <?php echo get_post_meta( get_the_ID(), 'type', true ); ?></p>
						<p>Année : <?php echo get_the_date('Y'); ?></p>
						<div class="separator"></div>
			</div>
			<div class="photo-content">
						<?php the_content(); ?>
			</div>
		</div>
		<div class="contact-single-container">
			<div class="contact-container">
					<p>Cette photo vous intéresse ?</p>
					<button id="photoContactBtn">Contact</button>
			</div>
			<div class="separator"></div>
		</div>	
	</div>
	<?php

	if ( is_attachment() ) {
		// Parent post navigation.
		the_post_navigation(
			array(
				'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone' ), '%title' ),
			)
		);
	}

	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}

	// Previous/next post navigation.
	$twentytwentyone_next = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' );
	$twentytwentyone_prev = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' );

	$twentytwentyone_next_label     = esc_html__( 'Next post', 'twentytwentyone' );
	$twentytwentyone_previous_label = esc_html__( 'Previous post', 'twentytwentyone' );

	the_post_navigation(
		array(
			'next_text' => '<p class="meta-nav">' . $twentytwentyone_next_label . $twentytwentyone_next . '</p><p class="post-title">%title</p>',
			'prev_text' => '<p class="meta-nav">' . $twentytwentyone_prev . $twentytwentyone_previous_label . '</p><p class="post-title">%title</p>',
		)
	);

endwhile; // End of the loop.

get_footer();
