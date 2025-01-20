<?php
/*
Template Name: Home Page
*/
get_header();
?>
<section class="hero">
 
    <div class="owl-carousel owl-theme owl-carousel-hero">
        <?php 
        // Query posts
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $query = new WP_Query($args);
        
        if($query->have_posts()) :
            while($query->have_posts()) : $query->the_post();
                
                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'original');
        ?>
         
            <div class="item">
            <div class="hero-title-top">
                    <h2><?php echo wp_trim_words(get_the_title(), 7); ?></h2>
                </div>
                <div class="itm-image">
                    <?php if($featured_img_url) : ?>
                        <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <?php endif; ?>
                </div>
                
                <div class="img-content">
                    <h2><?php  echo esc_html(get_the_title()); ?></h2>
                     <p><?php echo wp_trim_words(get_the_excerpt(), 50); ?></p>
                    <div class="read-more-button">
                        <a href="<?php echo esc_url(get_permalink()); ?>">Read More ></a>
                    </div>
                </div>
                <div class="hero-content-top">
                <p><?php echo wp_trim_words(get_the_excerpt(), 50); ?></p>
                <div class=" top-read-more ">
                <div class="read-more-button">
                        <a href="<?php echo esc_url(get_permalink()); ?>">Read More ></a>
                    </div>
              </div>

</div>
            </div>
        <?php 
            endwhile;
            wp_reset_postdata();  
        else : 
        ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</section>


 
 
 <section class="main-posts-features row-brdr">
    <div class="container">
        <div class="row ">
            <div class="col-xl-8 col-md-7 col-brdr col-padd-2">
                <div class="featured-heading">
                    <h2>Featured Post</h2>
                </div>
                <div class="featured-post">
                  
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 1,
                        'orderby' => 'date',
                        'order' => 'ASC'
                    );

                    $featured_query = new WP_Query($args);

                    if($featured_query->have_posts()) : 
                        while($featured_query->have_posts()) : $featured_query->the_post();
                            // Debug information
                            echo '<!-- 
                            Post ID: ' . get_the_ID() . '
                            Post Title: ' . get_the_title() . '
                            Categories: ';
                            $categories = get_the_category();
                            foreach($categories as $cat) {
                                echo $cat->name . ', ';
                            }
                            echo ' -->';
                    ?>
                        <div class="featured-img">
                            <?php 
                            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            if($featured_img_url) : ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/Featured-img-top.png" alt="Featured-top img" class="img-fluid">
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="featured-post-desc">
                            <div class="featured-post-date">
                                <p><?php echo get_the_date('d-m-Y'); ?></p>
                            </div>
                            <div class="divider"></div>
                            <?php
                            if($categories) :
                                $tag_number = 1;  
                                foreach($categories as $category) :
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
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<!-- No posts found -->'; 
                    endif;
                    ?>
                </div>




<!-- all posts -->

                <div class="featured-bottom">
                  
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 6,
                        'offset' => 0,  
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );

                    $bottom_query = new WP_Query($args);
                    $post_count = 0; // Initialize a counter

                    if($bottom_query->have_posts()) :
                        while($bottom_query->have_posts()) : $bottom_query->the_post();
                            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $post_count++; // Increment the counter
                            $odd_class = ($post_count % 2 !== 0) ? 'odd-post' : ''; // Add class for odd posts
                    ?>
                        <div class="featured-bottom-post <?php echo esc_attr($odd_class); ?>">
                            <div class="bottom-post-img">
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <?php if($featured_img_url) : ?>
                                        <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
                                     <?php endif; ?>
                                </a>
                            </div>
                            <div class="bottom-post-content">
                                <div class="bottom-post-heading bph-heading-top">
                                  <h2>
                                      <a href="<?php echo esc_url(get_permalink()); ?>">
                                          <?php echo esc_html(get_the_title()); ?>
                                      </a>
                                  </h2>     
                                </div>
                                <div class="bottom-post-desc">
                                    <div class="featured-post-date">
                                        <p><?php echo get_the_date('d-m-Y'); ?></p>
                                    </div>
                                    <div class="divider"></div>
                                    <?php
                                    $categories = get_the_category();
                                    if($categories) :
                                        $tag_number = 1; // Initialize counter for tag numbers
                                        foreach($categories as $category) :
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
                                    <p><?php echo get_the_excerpt(); ?></p>
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
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>No posts found</p>';
                    endif;
                    ?>
                </div>

                <?php if ($post_count >= 6) : ?>
                    <div id="load-more-bttn" class="load-more">
                        <a href="#" id="load-more-posts" data-page="1">Load More ></a>
                    </div>
                <?php endif; ?>
            </div>







<!-- ending posts -->

            <div class="col-xl-4 col-md-5  col-padd">
                <div class="categories-section">
                    <div class="category-heading">
                        <h2>Categories</h2>
                    </div>
                    <div class="categories-galary">
                        <div class="row galary-row">
                            <?php
                            $categories = get_categories(array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'number' => 4
                            ));

                            $category_chunks = array_chunk($categories, 2);

                            foreach($category_chunks as $index => $chunk) :
                            ?>
                                <div class="col-6 <?php echo ($index == 1) ? 'padding-none' : ''; ?>">
                                    <div class="cg-images">
                                        <?php 
                                        foreach($chunk as $category) :
                                            $category_image = get_category_image($category->term_id);
                                            
                                            if($category_image) :
                                                $file_extension = pathinfo($category_image, PATHINFO_EXTENSION);
                                                $image_class = strtolower($file_extension) === 'svg' ? 'svg-fluid' : 'img-fluid';
                                        ?>
                                        <div class="category-img-content">
                                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                                <img src="<?php echo esc_url($category_image); ?>" 
                                                     alt="<?php echo esc_attr($category->name); ?>" 
                                                     class="<?php echo $image_class; ?>">
                                                <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                            </a>
                                            </div>
                                        <?php 
                                            else:
                                        ?>
                                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                                <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                            </a>
                                        <?php
                                            endif;
                                        endforeach; 
                                        ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="category-divider">

                </div>
                <div class="featured-product">
                    <div class="product-heading">
                        <h2>Featured Products</h2>
                    </div>
                    <div class="product-cards">
                        <?php
                        $args = array('post_type' => 'product', 'posts_per_page' => -1);
                        $products = new WP_Query($args);
                        if ($products->have_posts()) :
                            while ($products->have_posts()) : $products->the_post();
                                $subtitle = get_post_meta(get_the_ID(), '_product_subtitle', true);
                                $price = get_post_meta(get_the_ID(), '_product_price', true);
                                $visit_link = get_post_meta(get_the_ID(), '_product_visit_link', true);

                        ?>
                                <div class="product-card">
                                    <div class="product-card-img">
                                        <a href="<?php echo esc_url($visit_link); ?>" target="_blank">
                                            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                                        </a>
                                    </div>
                                    <div class="product-card-content">
                                        <a href="<?php echo esc_url($visit_link); ?>" target="_blank">
                                            <h6><?php the_title(); ?></h6>
                                        </a>
                                         <a href="<?php echo esc_url($visit_link); ?>" target="_blank">
                                            <h5><?php echo esc_html($subtitle); ?></h5>
                                        </a>
                                        <p>$<?php echo esc_html($price); ?></p>
                                        <a href="<?php echo esc_url($visit_link); ?>" target="_blank">Visit Site <img src="<?php echo get_template_directory_uri(); ?>/assets/images/next_arrow.svg" alt="arrow"></a>
                                    </div>
                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p>No products found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
                <div class="category-divider"></div>

                <div class="popular-article">
                    <div class="popular-article-heading">
                        <h2>Popular Articles</h2>
                    </div>
                    <div class="popular-article-content">
                        <div class="article-cards">
                            <?php
                            // Query to fetch 5 posts from the 'post' post type (or change to your desired post type)
                            $args = array(
                                'post_type' => 'post', // Change this if you want to fetch from a different post type
                                'posts_per_page' => 5,
                                'orderby' => 'comment_count', // Example: Order by number of comments to get popular articles
                                'order' => 'DESC'
                            );
                            $popular_articles = new WP_Query($args);
                            if ($popular_articles->have_posts()) :
                                while ($popular_articles->have_posts()) : $popular_articles->the_post();
                            ?>
                                    <div class="article-card">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="article-card-img">
                                                <?php 
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('medium', ['class' => 'img-fluid']); 
                                                } else {
                                                    echo '<img src="' . get_template_directory_uri() . '/assets/images/default-image.png" alt="Default Image" class="img-fluid" />'; // Fallback image
                                                }
                                                ?>
                                            </div>
                                            <div class="article-card-content">
                                                <h5><?php the_title(); ?></h5>
                                                <p><?php echo get_the_date(); ?></p>
                                            </div>
                                        </a>
                                    </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                echo '<p>No popular articles found.</p>';
                            endif;
                            ?>
                        </div>
                    </div>
                </div>

               
            </div>
            </div>
        </div>
    </div>
 </section>

 <section class="section-end">
    <div class="end-img">
        <?php 
        // Query for latest 6 posts
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $query = new WP_Query($args);
        
        if($query->have_posts()) :
            while($query->have_posts()) : $query->the_post();
                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'original');
                if($featured_img_url) :
        ?>
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <img src="<?php echo esc_url($featured_img_url); ?>" 
                         alt="<?php echo esc_attr(get_the_title()); ?>" 
                         class="img-fluid">
                </a>
        <?php 
                endif;
            endwhile;
            wp_reset_postdata();
        
        endif; 
        ?>
    </div>
      </section>


 <?php get_footer() ?>
