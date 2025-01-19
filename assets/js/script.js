function openMenu() {
  document.getElementById('sideMenu').style.right = '0';
}

function closeMenu() {
  document.getElementById('sideMenu').style.right = '-326px';
}

// Ensure the document is ready before initializing the carousel
jQuery(document).ready(function($) {
  $('.owl-carousel-hero').owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      responsive: {
          0: {
              items: 1
          }
      }
  });
});



// ============Load More Posts Functionality============

jQuery(document).ready(function($) {
  var button = $('#load-more-posts');
  var loading = false;
  var container = $('.featured-bottom');
  var load_btn = $('#load-more-bttn');
  let currentPage = 1; // Initialize current page

  button.off('click').on('click', function(e) {
      e.preventDefault();
      
      if (loading) {
          return false;
      }

      loading = true;
      button.text('Loading...');

      // Use currentPage instead of button.data('page')
      $.ajax({
          url: ajax_params.admin_url,
          type: 'POST',
          data: {
              action: 'load_more_posts',
              page: currentPage + 1, // Send the current page
              nonce: ajax_params.nonce
          },
          success: function(response) {
              console.log('Response:', response);
              if (response.success) {
                  container.append(response.data.html); // Append new posts HTML
                  currentPage++; 
                  button.text('Load More >');

                  // Check if we need to hide the button
                  if (response.data.hide_button) {
                      load_btn.hide(); // Hide button if fewer than 6 posts
                      console.log('Hiding Load More button');
                  }
              } else {
                  load_btn.hide(); // Hide button if no more posts
                  console.log('Hiding Load More button');
              }
          },
          error: function(xhr, status, error) {
              console.log('Error:', error);
              button.text('Error Loading Posts');
          },
          complete: function() {
              loading = false;
          }
      });

      return false;
  });
});




// js for upload image for category
jQuery(document).ready(function($) {
  // Handle image upload
  $(document).on('click', '.upload-category-image', function(e) {
      e.preventDefault();
      
      var button = $(this);
      var container = button.closest('.category-image-field');
      var imageWrapper = container.find('.category-image-wrapper img');
      var imageIdInput = container.find('.category-image-id');
      var removeButton = container.find('.remove-category-image');

      var frame = wp.media({
          title: 'Select or Upload Category Image',
          button: {
              text: 'Use this image'
          },
          multiple: false
      });

      frame.on('select', function() {
          var attachment = frame.state().get('selection').first().toJSON();
          imageIdInput.val(attachment.id);
          imageWrapper.attr('src', attachment.url).show();
          removeButton.show();
      });

      frame.open();
  });

  // Handle image removal
  $(document).on('click', '.remove-category-image', function(e) {
      e.preventDefault();
      
      var button = $(this);
      var container = button.closest('.category-image-field');
      var imageWrapper = container.find('.category-image-wrapper img');
      var imageIdInput = container.find('.category-image-id');

      imageIdInput.val('');
      imageWrapper.attr('src', '').hide();
      button.hide();
  });
});

//  for category page load more button

// ============Load More Posts Functionality============
 