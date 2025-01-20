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
                <!-- <h1>The Skin Edit</h1> -->
                <?php
                
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
                    <div class="src-toggle">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/search.svg" alt="search">
                    </div>
                    <div class="src-form-div">
                        <div class="src-close">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512.021 512.021;" xml:space="preserve" width="512" height="512">
                            <g>
                                <path d="M301.258,256.01L502.645,54.645c12.501-12.501,12.501-32.769,0-45.269c-12.501-12.501-32.769-12.501-45.269,0l0,0   L256.01,210.762L54.645,9.376c-12.501-12.501-32.769-12.501-45.269,0s-12.501,32.769,0,45.269L210.762,256.01L9.376,457.376   c-12.501,12.501-12.501,32.769,0,45.269s32.769,12.501,45.269,0L256.01,301.258l201.365,201.387   c12.501,12.501,32.769,12.501,45.269,0c12.501-12.501,12.501-32.769,0-45.269L301.258,256.01z"/>
                            </g>
                        </svg>
                        </div>
                        <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                            <label>
                                <span class="screen-reader-text"><?php _e('Search for:', 'textdomain'); ?></span>
                                <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search...', 'textdomain'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            </label>
                            <button type="submit" class="search-submit">
                                <?php _e('Search', 'textdomain'); ?>
                            </button>
                        </form>
                    </div>
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