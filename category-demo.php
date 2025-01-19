<?php
get_header(); // Include the header

if (have_posts()) : ?>
<div class="container">
    <div class="featured-heading"> 
    <h1><?php single_cat_title(); ?></h1> <!-- Display the category title -->

         
                  
                  <?php
                  $args = array(
                      'post_type' => 'post',
                      'posts_per_page' => 4,
                      'orderby' => 'date',
                      'order' => 'DESC'
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
                  <div class="featured-post-content">
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
                  <?php
                      endwhile;
                      wp_reset_postdata();
                  else:
                      echo '<!-- No posts found -->'; 
                  endif;
                  ?>
              </div>

        </div>
  
    
<?php else : ?>
    <p><?php _e('No posts found in this category.', 'textdomain'); ?></p> <!-- Message if no posts found -->
<?php endif;

get_footer(); // Include the footer 
