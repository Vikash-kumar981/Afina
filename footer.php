<footer>
    <div class="container">
        <div class="footer-content">
        <?php
    // Fetch the custom logo
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
?>

<a href="<?php echo esc_url(home_url()); ?>" class="logo-link">
    <?php if ($logo) : ?>
        <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo">
     
    <?php endif; ?>
</a>
        <p>Your trusted destination for honest reviews on beauty, wellness, and lifestyle products. <br> 
            We help you make informed choices to glow and thrive every day!</p>

            <h4>We Are Open from <span>Sun - Mon 10 AM - 22 PM</span></h4>
        </div>
        <div class="footer-end">
            <div class="copy-right">
                <p>Copyright © 2020. Crafted with love.</p>
            </div>
            <div class="tc">
                <a href="#">Terms and Conditions</a>
                <div class="tc-divider">|</div>
                <a href="#">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>

</body>

</html>