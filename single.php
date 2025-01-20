<?php get_header(); ?>

<main>
    <div class="row1">
        <div class="col">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <section class="budget-friendly">
                    <div class="budget-friendly-content">
                    <div class="bf-skin-care-button">
                            <!-- <a href="#">Skin Care</a> -->
                            <?php
                            // Get the categories of the current post
                            $categories = get_the_category();

                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="post-category">' . esc_html($category->name) . '</a> ';
                                }
                            }
                            ?>
                    </div>
                        <h2>
                        <?php the_title(); ?>
                        </h2>
                        <p><?php echo date('d-m-Y'); ?></p>
                    </div>
                </section> 
                <section class="archive-main">
                    <div class="container">
                        <div class="am-top-image-container">
                            <div class="am-top-image">
                            <?php if (has_post_thumbnail()): ?>
                                    <div class="featured-image">
                                        <?php the_post_thumbnail('large'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="am-top-image-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                </section>
                    <div class="content">
                        <div class="container">
                        <?php the_content(); ?>
                        </div>
                    </div>
                    <div class="comments-div">
                    <div class="container">
                        <?php
                            // Check if comments are open or there are comments
                            if (comments_open() || get_comments_number()) {
                                comments_template();
                            }
                        ?>
                    </div>
                    </div>
                </article>
            <?php endwhile; else: ?>
                <!-- Default posts to show when no posts are available -->
                <article class="default-post">
                    <header>
                        <h1>No Posts Available</h1>
                    </header>
                    <div class="content">
                        <p>It seems there are no posts to display at the moment. Please check back later!</p>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </div>
    <section class="archive-main1">
        <div class="container">
            <div class="am-top-trending">
                <div class="am-top-trending-heading">
                    <h3>Top Trending</h3>
                    <h2>Related Post</h2>
                </div>
                <div class="am-top-trending-cards">
                    <div class="row">
                        <?php
                        // Fetch the latest 3 posts
                        $latest_posts_query = new WP_Query(array(
                            'post_type' => 'post',
                            'posts_per_page' => 3, // Limit to 3 posts
                            'post__not_in'   => array(get_the_ID()),
                            'post_status' => 'publish', // Only published posts
                            'orderby' => 'date', // Order by date
                            'order' => 'DESC' // Most recent first
                        ));
                        ?>
                        <?php if ($latest_posts_query->have_posts()) : ?>
                            <?php while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post(); ?>
                                <div class="col-md-4">
                                    <div class="am-top-trending-card">
                                        <div class="am-top-trending-card-img">
                                        <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="img-fluid">
                                                <?php else : ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/default-image.png" alt="Default Image" class="img-fluid"> <!-- Default image if no thumbnail -->
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="am-top-trending-card-content">
                                            <div class="am-top-trending-card-content-heading">
                                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                                    <h2><?php echo wp_trim_words(get_the_title(), 8); ?></h2>
                                                </a>                                            </div>
                                            <div class="am-top-trending-card-content-desc1">
                                                 
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
                                            </div>
                                            <div class="am-top-trending-card-read-more-btn">
                                                <a href="<?php echo esc_url(get_permalink()); ?>">Read Now <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.4099 6.57668L11.3451 0.511963L10.4361 1.42096L16.371 7.35711H0V8.64282H16.3736L10.4361 14.579L11.3451 15.488L17.4099 9.42453C17.7904 9.04396 18 8.53739 18 7.99996C18 7.46253 17.7904 6.95596 17.4099 6.57796V6.57668Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); // Reset post data after the loop ?>
                        <?php else : ?>
                            <p>No posts found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
