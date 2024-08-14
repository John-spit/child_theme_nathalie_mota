<div class="related-photo-item">
    <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail(); ?>
    </a>
    <div class="photo-icons">
        <a href="<?php the_permalink(); ?>" class="icon-eye" title="Voir les informations"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/eye.png" alt="Voir les informations"></a>
        <a href="<?php echo esc_url( get_the_post_thumbnail_url(get_the_ID(), 'full') ); ?>" class="icon-fullscreen" title="Voir en plein écran" data-lightbox="related-photos"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fullscreen.png" alt="Voir en plein écran"></a>
    </div>
</div>