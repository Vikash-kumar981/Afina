<div id="comments" class="comments-area">
    <h2 class="comments-title">
        Comments-<?php echo get_comments_number(); ?>
    </h2>

    <ol class="comment-list">
        <?php
        wp_list_comments(array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 60, // Adjust avatar size
            'callback'    => 'custom_comments_callback', // Use a custom callback for styling
        ));
        ?>
    </ol>

    <?php
    // If comments are closed
    if (!comments_open() && get_comments_number()) {
        echo '<p class="no-comments">Comments are closed.</p>';
    }

    // Display the comment form
    comment_form(array(
        'class_submit' => 'submit-button', // Add custom class to the submit button
        'label_submit' => __('Post>'),
    ));
    ?>
</div>
