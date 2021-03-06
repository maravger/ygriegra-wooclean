<?php
function wooclean_child_enqueue_styles() {

    //$parent_style = 'responsive'; 

    //wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    //require_once( get_stylesheet_directory() . '/footer.php' );
// get_template_directory_uri() , this equals the parent folder
// get_stylesheet_directory_uri() this would equal the child folder
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	//wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'responsive', get_stylesheet_directory_uri() . '/responsive.css' );
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/css/custom-style.css' );

// REMEMBER TO ENQUEUE CUSTOM SCRIPTS FROM PARENT
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true );
    wp_enqueue_script( 'owl.carousel', get_template_directory_uri()  . '/js/owl-carousel/owl.carousel.js', array('jquery'), false, true );
    wp_enqueue_script( 'et-modernizr', get_template_directory_uri()  . '/js/et-modernizr.js', array('jquery'), false, true );
    // wp_enqueue_script( 'et-scripts', get_template_directory_uri()  . '/js/main-script.js', array('jquery'), false, true );
    wp_enqueue_script( 'et-scripts', get_stylesheet_directory_uri()  . '/js/main-script.js', array('jquery'), false, true );
    

    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'wooclean_child_enqueue_styles' );

function wpse_enqueue_page_template_styles() {
    if ( is_page_template( 'page-cleanpage.php' ) ) {
        wp_enqueue_style( 'cleanpage-template', get_stylesheet_directory_uri() . '/css/cleanpage-template.css' );
    }
}

// split content at the more tag and return an array
function split_content() {

    global $more;
    $more = true;
    $content = preg_split('/<span id="more-d+"></span>/i', get_the_content('more'));
    for($c = 0, $csize = count($content); $c < $csize; $c++) {
        $content[$c] = apply_filters('the_content', $content[$c]);
    }
    return $content;

}

function register_my_menu() {
  register_nav_menu('bottom-menu',__( 'Bottom Menu' ));
}

add_action( 'init', 'register_my_menu' );
add_action( 'wp_enqueue_scripts', 'wpse_enqueue_page_template_styles' );

function wmpudev_enqueue_icon_stylesheet() {
    wp_register_style( 'fontawesome', 'http:////maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'fontawesome');
}
add_action( 'wp_enqueue_scripts', 'wmpudev_enqueue_icon_stylesheet' );

// Move WooCommerce price
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
// add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

add_action( 'wp_enqueue_scripts', 'wc_remove_lightboxes', 99 );

  /**
   * Remove WooCommerce default prettyphoto lightbox
  */

   function wc_remove_lightboxes() {    
     // Styles
     wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
     // Scripts
     wp_dequeue_script( 'prettyPhoto' );
     wp_dequeue_script( 'prettyPhoto-init' );
     wp_dequeue_script( 'fancybox' );
     wp_dequeue_script( 'enable-lightbox' );
  }


/* Customize Product Gallery */

/**
 * Click on thumbnail to view image for single product page gallery. Includes 
 * responsive image support using 'srcset' attribute introduced in WP 4.4
 * @link https://make.wordpress.org/core/2015/11/10/responsive-images-in-wordpress-4-4/
 */

add_action( 'wp_footer', 'wc_gallery_override' );

function wc_gallery_override()
{       
  // Only include if we're on a single product page.
  if (is_product()) {
  ?>
    <script type="text/javascript">
        ( function( $ ) {

            // Override default behavior
            $('.woocommerce-product-gallery__image').on('click', function( event ) {
                event.preventDefault();
            });

            // Find the individual thumbnail images
            var thumblink = $( '.thumbnails .zoom' );

            // Add our active class to the first thumb which will already be displayed 
            //on page load.
            thumblink.first().addClass('active');

            thumblink.on( 'click', function( event ) {

                // Override default behavior on click.
                event.preventDefault();

                // We'll generate all our attributes for the new main
                // image from the thumbnail.
                var thumb = $(this).find('img');

                // The new main image url is formed from the thumbnail src by removing 
                // the dimensions appended to the file name.
                var photo_fullsize =  thumb.attr('src').replace('-600x600','');

                // srcset attributes are associated with thumbnail img. We'll need to also change them.
                var photo_srcset =  thumb.attr('srcset');

                // Retrieve alt attribute for use in main image.
                var alt = thumb.attr('alt');

                // If the selected thumb already has the .active class do nothing.
                if ($(this).hasClass('active')) {
                    return false;
                } else { 

                    // Remove .active class from previously selected thumb.
                    thumblink.removeClass('active');

                    // Add .active class to new thumb.
                    $(this).addClass('active');

                    // Fadeout main image and replace various attributes with those defined above. Once the image is loaded we'll make it visible.
                    $('.woocommerce-product-gallery__image img').css( 'opacity', '0' ).attr('src', photo_fullsize).attr('srcset', photo_srcset).attr('alt', alt).load(function() {
                        $(this).animate({ opacity: 1 });
                    });
                    return false;
                    }
                });
        } )( jQuery ); 
    </script>
<?php
}
}


?>