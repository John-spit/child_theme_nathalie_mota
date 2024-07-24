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
</body>
</html>
