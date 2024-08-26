<div class="related-photo-item">
    <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail(); ?>
    </a>
    <div class="photo-icons">
        <a href="<?php the_permalink(); ?>" class="icon-eye" title="Voir les informations">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/eye.png" alt="Voir les informations">
        </a>
        <a href="<?php echo esc_url( get_the_post_thumbnail_url(get_the_ID(), 'full') ); ?>" 
           class="icon-fullscreen" 
           title="Voir en plein écran" 
           data-lightbox="related-photos" 
           data-reference="<?php echo get_post_meta( get_the_ID(), 'reference', true ); ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fullscreen.png" alt="Voir en plein écran">
        </a>
    </div>
    <div class="photo-info">
        <span class="photo-title"><?php the_title(); ?></span>
        <span class="photo-category">
            <?php
            // Récupère les catégories du post
            $categories = get_the_terms(get_the_ID(), 'categorie');

            if ($categories && !is_wp_error($categories)) {
                $category_names = array_map(function($term) {
                    return $term->name;
                }, $categories);

                $category_list = implode(', ', $category_names); 
                echo '<div>' . esc_html($category_list) . '</div>';
            }
            ?>
        </span>
    </div>
</div>