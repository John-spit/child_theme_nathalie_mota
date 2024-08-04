<div class="related-photos">
    <?php
    $categories = get_the_terms( get_the_ID(), 'categorie' );
    if ( $categories && ! is_wp_error( $categories ) ) {
        $category_ids = wp_list_pluck( $categories, 'term_id' );
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 2,
            'post__not_in' => array( get_the_ID() ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'term_id',
                    'terms'    => $category_ids,
                ),
            ),
            'orderby' => 'rand',
        );

        $related_photos_query = new WP_Query( $args );
        if ( $related_photos_query->have_posts() ) {
            while ( $related_photos_query->have_posts() ) {
                $related_photos_query->the_post();
                ?>
                <div class="related-photo-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(); ?>
                    </a>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {
            echo '<p>Pas de photos trouvées.</p>';
        }
    }
    ?>
</div>

		