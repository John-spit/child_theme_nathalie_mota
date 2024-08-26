<div id="photo-lightbox" class="lightbox-overlay">
    <div class="lightbox-content">
        <img id="lightbox-image" src="" alt="Photo en plein écran" />

        <div class="lightbox-info">
            <p id="lightbox-reference">Référence de la photo</p>
            <p id="lightbox-category">Catégorie</p>
        </div>


        <a href="#" class="lightbox-arrow lightbox-prev">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-left-white.png" alt="Précédente">
            <span>Précédente</span>
        </a>
        <a href="#" class="lightbox-arrow lightbox-next">
            <span>Suivante</span>
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-right-white.png" alt="Suivante">
        </a>

      
        <a href="#" class="lightbox-close">&times;</a>
    </div>
</div>

<footer>
    <div class="footer-container">
        <nav>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_class' => 'footer-menu',
            ));
            ?>
        </nav>
    </div>
</footer>
<?php wp_footer(); ?>
<?php get_template_part('templates_parts/popup-contact'); ?>
</body>
</html>
