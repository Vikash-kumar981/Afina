<?php get_header(); ?>

<div class="search-results">
    <h1><?php printf(__('Search Results for: %s', 'textdomain'), get_search_query()); ?></h1>

    <?php if (have_posts()) : ?>
        <ul>
            <?php while (have_posts()) : the_post(); ?>
                <li>
                <div class="category-post-content">
                    
                    <div class="featured-img">
                        <?php 
                        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                       
                        if($featured_img_url) : ?>
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
                </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p><?php _e('No results found. Please try a different search.', 'textdomain'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?> 