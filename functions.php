<?php
function enqueue_css() {
  wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3', 'all');
  wp_enqueue_style('owl-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array(), '2.3.4', 'all');
  wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4', 'all');
  wp_enqueue_style('google-font-sen', 'https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap', array(), null, 'all');
  wp_enqueue_style('google-font-spirax', 'https://fonts.googleapis.com/css2?family=Spirax&display=swap', array(), null, 'all');
  wp_enqueue_style('custom-fonts', get_template_directory_uri() . '/assets/arial-font/arial.ttf', array(), null, 'all');
  wp_enqueue_style('custom-global', get_template_directory_uri() . '/assets/css/style.css', array(), null, 'all');
  wp_enqueue_style('custom-category-css', get_template_directory_uri() . '/assets/css/category.css', array(), null, 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_css');

function enqueue_script()
{
    wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true);
    wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.3', true); 
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/js/script.js', array(), null, 'all');
 
}
add_action('wp_enqueue_scripts', 'enqueue_script');

function add_theme_features() {
  // Add featured image support
  add_theme_support('post-thumbnails');
  
  // Add category image support
  add_theme_support('category-thumbnails');
  
  // Register term meta for category images
  register_term_meta('category', 'thumbnail_id', [
      'type' => 'integer',
      'single' => true,
      'show_in_rest' => true,
  ]);


 // Theme menus support setting
    // Enable menu support
    add_theme_support('menus');

    // Register menus
    register_nav_menus(
        array(
            'main-menu' => __('Main Menu', 'theme')
        )
    );
}
add_action('after_setup_theme', 'add_theme_features');


// Add category image field
function add_category_image_field() { ?>
    <div class="form-field term-group">
        <label><?php _e('Category Image', 'your-theme'); ?></label>
        <div class="form-field category-image-field">
            <input type="hidden" class="category-image-id" name="category_image_id" value="">
            <div class="category-image-wrapper">
                <img src="" style="width:200px;height:auto;display:none;" />
            </div>
            <button type="button" class="button upload-category-image"><?php _e('Add Image', 'your-theme'); ?></button>
            <button type="button" class="button remove-category-image" style="display:none;"><?php _e('Remove Image', 'your-theme'); ?></button>
        </div>
    </div>
<?php }
add_action('category_add_form_fields', 'add_category_image_field');

// Edit category image field
function edit_category_image_field($term) {
    $image_id = get_term_meta($term->term_id, 'category_image_id', true);
    $image_url = wp_get_attachment_url($image_id);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label><?php _e('Category Image', 'your-theme'); ?></label>
        </th>
        <td class="category-image-field">
            <input type="hidden" class="category-image-id" name="category_image_id" value="<?php echo esc_attr($image_id); ?>">
            <div class="category-image-wrapper">
                <img src="<?php echo esc_url($image_url); ?>" style="width:200px;height:auto;<?php echo empty($image_url) ? 'display:none;' : ''; ?>" />
            </div>
            <button type="button" class="button upload-category-image"><?php _e('Change Image', 'your-theme'); ?></button>
            <button type="button" class="button remove-category-image" <?php echo empty($image_url) ? 'style="display:none;"' : ''; ?>><?php _e('Remove Image', 'your-theme'); ?></button>
        </td>
    </tr>
<?php }
add_action('category_edit_form_fields', 'edit_category_image_field');

// Save category image
function save_category_image($term_id) {
    if (isset($_POST['category_image_id'])) {
        $image_id = absint($_POST['category_image_id']);
        update_term_meta($term_id, 'category_image_id', $image_id);
    }
}
add_action('created_category', 'save_category_image');
add_action('edited_category', 'save_category_image');

// Get category image (helper function to use in templates)
function get_category_image($term_id) {
    $image_id = get_term_meta($term_id, 'category_image_id', true);
    return wp_get_attachment_url($image_id);
}

// Enqueue admin scripts and styles
function enqueue_category_image_scripts($hook) {
    // Only load on category pages
    if ('edit-tags.php' != $hook && 'term.php' != $hook) {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_script(
        'category-image-js',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('admin_enqueue_scripts', 'enqueue_category_image_scripts');

// Ensure proper scripts are loaded in admin
function load_media_files() {
  wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'load_media_files');






// ============ LOAD MORE BUTTON Ajax for home page ===========
function load_more_posts() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_nonce')) {
        die('Nonce verification failed');
    }

    // Get the current page and posts per page
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = 6;

    // Calculate offset
    $offset = ($page - 1) * $posts_per_page;

    // Set up the query arguments
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );

    $query = new WP_Query($args);
    
    if ($query->have_posts()) :
        $posts_html = '';  
        while ($query->have_posts()) : $query->the_post();
            ob_start(); // Start output buffering
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
            <div class="featured-bottom-post <?php echo ($query->current_post % 2 === 0) ? 'odd-post' : ''; ?>">
                <div class="bottom-post-img">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <?php if ($featured_img_url) : ?>
                            <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
                        <?php endif; ?>
                    </a>
                </div>
                <div class="bottom-post-content">
                    <div class="bottom-post-heading bph-heading-top">
                        <h2><?php echo esc_html(get_the_title()); ?></h2>
                    </div>
                    <div class="bottom-post-desc">
                        <div class="featured-post-date">
                            <p><?php echo get_the_date('d-m-Y'); ?></p>
                        </div>
                        <div class="divider"></div>
                        <?php
                        $categories = get_the_category();
                        if ($categories) :
                            $tag_number = 1; // Initialize counter for tag numbers
                            foreach ($categories as $category) :
                        ?>
                            <div class="featured-btn tag-<?php echo $tag_number; ?>">
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </div>
                        <?php 
                            $tag_number++;  
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <div class="bottom-post-heading bph-heading-bottom">
                        <h2><?php echo esc_html(get_the_title()); ?></h2>
                    </div>
                    <div class="bottom-post-para">
                        <p><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
                    </div>
                    <div class="bp-read-more">
                        <a href="<?php echo esc_url(get_permalink()); ?>">Read More <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4099 6.57668L11.3451 0.511963L10.4361 1.42096L16.371 7.35711H0V8.64282H16.3736L10.4361 14.579L11.3451 15.488L17.4099 9.42453C17.7904 9.04396 18 8.53739 18 7.99996C18 7.46253 17.7904 6.95596 17.4099 6.57796V6.57668Z" fill="black"/>
                        </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php
            $posts_html .= ob_get_clean(); // Append the output to posts_html
        endwhile;
        wp_reset_postdata();

        // Check if the number of posts is less than 6
        $hide_button = $query->post_count < $posts_per_page; // Determine if button should be hidden
        wp_send_json_success(array('html' => $posts_html, 'hide_button' => $hide_button)); // Send HTML and button visibility
        die();
    else : 
        wp_send_json_error('No more posts');
    endif;
}

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

// Enqueue script with proper localization
function enqueue_load_more_scripts() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), time(), true);
    
    wp_localize_script('custom-script', 'ajax_params', array(
        'admin_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_scripts');


//=============Register Custom Post Type for Products=============

function create_product_cpt() {
    $labels = array(
        'name' => __('Products'),
        'singular_name' => __('Product'),
        'menu_name' => __('Featured Products'),
        'name_admin_bar' => __('Product'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Product'),
        'new_item' => __('New Product'),
        'edit_item' => __('Edit Product'),
        'view_item' => __('View Product'),
        'all_items' => __('All Products'),
        'search_items' => __('Search Products'),
        'not_found' => __('No products found.'),
        'not_found_in_trash' => __('No products found in Trash.'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'products'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('product', $args);
}
add_action('init', 'create_product_cpt');

// Add custom fields for subtitle, price, and visit link
function add_product_meta_boxes() {
    add_meta_box('product_subtitle', 'Subtitle', 'render_product_subtitle_meta_box', 'product', 'normal', 'high');
    add_meta_box('product_price', 'Price', 'render_product_price_meta_box', 'product', 'normal', 'high');
    add_meta_box('product_visit_link', 'Visit Site URL', 'render_product_visit_link_meta_box', 'product', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_product_meta_boxes');

function render_product_subtitle_meta_box($post) {
    $subtitle = get_post_meta($post->ID, '_product_subtitle', true);
    echo '<input type="text" name="product_subtitle" value="' . esc_attr($subtitle) . '" style="width:100%;" />';
}

function render_product_price_meta_box($post) {
    $price = get_post_meta($post->ID, '_product_price', true);
    echo '<input type="text" name="product_price" value="' . esc_attr($price) . '" style="width:100%;" />';
}

function render_product_visit_link_meta_box($post) {
    $visit_link = get_post_meta($post->ID, '_product_visit_link', true);
    echo '<input type="url" name="product_visit_link" value="' . esc_attr($visit_link) . '" style="width:100%;" placeholder="https://example.com" />';
}

// Save custom fields
function save_product_meta($post_id) {
    if (array_key_exists('product_subtitle', $_POST)) {
        update_post_meta($post_id, '_product_subtitle', sanitize_text_field($_POST['product_subtitle']));
    }
    if (array_key_exists('product_price', $_POST)) {
        update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
    }
    if (array_key_exists('product_visit_link', $_POST)) {
        update_post_meta($post_id, '_product_visit_link', esc_url_raw($_POST['product_visit_link']));
    }
}
add_action('save_post', 'save_product_meta');

// Redirect to the product page
function redirect_product_page() {
    if (is_post_type_archive('product')) {
        wp_redirect(home_url('/products'));
        exit;
    }
}
add_action('template_redirect', 'redirect_product_page');

function afina_setup() {
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100, // Set the height of the logo
        'width'       => 400, // Set the width of the logo
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'afina_setup');


// load more for category page 








// ============ LOAD MORE BUTTON Ajax for Category Page ===========
function cat_load_more_posts() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_nonce')) {
        die('Nonce verification failed');
    }

    // Get the current page and posts per page
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1; // Current page
    $posts_per_page = 4; // Number of posts per page
 
     $offset = ($page - 1) * $posts_per_page;  

     $category_slug = isset($_POST['category_slug']) ? sanitize_text_field($_POST['category_slug']) : '';

     $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'category_name' => $category_slug   
    );

    $query = new WP_Query($args);
    $post_count_ct = 0;  

    if ($query->have_posts()) :
        $posts_html = '';  
        while ($query->have_posts()) : $query->the_post();
            ob_start();  
            
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $post_count_ct++;
            ?>
            <div class="category-post-content">
                <div class="featured-img">
                    <?php if ($featured_img_url) : ?>
                        <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/Featured-img-top.png" alt="Featured-top img" class="img-fluid">
                    <?php endif; ?>
                </div>
                <div class="featured-post-desc">
                    <div class="featured-post-date">
                        <p><?php echo get_the_date('d-m-Y'); ?></p>
                    </div>
                    <div class="divider"></div>
                    <?php
                    $categories = get_the_category();
                    if ($categories) :
                        $tag_number = 1;  
                        foreach ($categories as $category) :
                    ?>
                        <div class="featured-btn tag-<?php echo $tag_number; ?>">
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </div>
                    <?php 
                        $tag_number++;  
                        endforeach;
                    endif;
                    ?>
                </div>
                <div class="featured-img-title">
                    <h2><?php the_title(); ?></h2>
                    <p><?php echo get_the_excerpt(); ?></p>
                </div>
                <div class="read-more-button">
                    <a href="<?php echo esc_url(get_permalink()); ?>">Read More ></a>
                </div>
            </div>
            <?php
            $posts_html .= ob_get_clean(); // Append the output to posts_html
        endwhile;
        wp_reset_postdata(); // Reset post data after the loop

        // Determine if the button should be hidden
        $hide_button_cat =  $post_count_ct < $posts_per_page;  
        wp_send_json_success(array('html' => $posts_html, 'hide_button' => $hide_button_cat));
        die();
    else :
        wp_send_json_error('No more posts');
    endif;
}

add_action('wp_ajax_cat_load_more_posts', 'cat_load_more_posts');
add_action('wp_ajax_nopriv_cat_load_more_posts', 'cat_load_more_posts');



// Enqueue script with proper localization
function enqueue_cat_load_more_scripts() {
  // Ensure the script path is correct
  wp_enqueue_script('custom-script-21', get_template_directory_uri() . '/assets/js/cate.js', array('jquery'), null, true);
  
  // Localize the script with new data
  wp_localize_script('custom-script-21', 'ajax_params', array(
      'admin_url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('load_more_nonce'),
      'category_slug' => get_queried_object()->slug // Pass the current category slug to JavaScript
  ));
}

add_action('wp_enqueue_scripts', 'enqueue_cat_load_more_scripts');