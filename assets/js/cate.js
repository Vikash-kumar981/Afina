jQuery(document).ready(function ($) {
  var button = $('#cat-load-more-posts'); // Load More button
  var container = $('.featured-post-1'); // Container for posts
  var load_btn = $('#cat-load-more-bttn'); // Load More button wrapper
  let currentPage = 1; // Current page
  var loading = false; // Loading state

  button.off('click').on('click', function (e) {
      e.preventDefault();

      if (loading) {
          return false; // Prevent multiple clicks while loading
      }

      loading = true; // Set loading state
      button.text('Loading...'); // Change button text to Loading

      $.ajax({
          url: ajax_params.admin_url, // AJAX URL
          type: 'POST',
          data: {
              action: 'cat_load_more_posts', // Action to call in PHP
              page: currentPage + 1, // Increment page number
              nonce: ajax_params.nonce, // Security nonce
              category_slug: ajax_params.category_slug // Send the current category slug
          },
          success: function (response) {
              if (response.success) {
                  container.append(response.data.html);  
                  currentPage++;  
                  button.text('Load More >');  

                   
                  console.log("hide button: ", response.data.hide_button);
                  if (response.data.hide_button) {
                    console.log
                      load_btn.hide();
                  }
              } else {
                  load_btn.hide();  
              }
          },
          error: function (xhr, status, error) {
              button.text('Error Loading Posts');  
          },
          complete: function () {
              loading = false;  
          },
      });

      return false; // Prevent default action
  });
});
