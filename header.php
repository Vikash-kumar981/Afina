<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
   
    <!-- Hero-section -->
    <header>
        <div class="container">
           <div class="header-content">
            <div class="header-title">
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
            </div>
            <div class="haeder-icons">
                <div class="search">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/search.svg" alt="search">
                </div>
                <div class="header-divider">
                    
                </div>
                <div class="menu">
                    <button type="button" class="btn" onclick="openMenu()"><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/menu-img.svg" alt="menu"></button>
                </div>
                <div id="sideMenu" class="side-menu">
                    <div class="back-btn">
                        <button class="close-btn" onclick="closeMenu()"> BACK ></button>
                    </div>
                    
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'main-menu',
                        'menu_id'        => 'main-menu',
                        'container'      => 'nav',
                        'container_class' => 'dropdown-menu-container',
                    ) );
                    ?>
                </div>
        
        
            </div>
           </div>
        </div>
        
        </header>