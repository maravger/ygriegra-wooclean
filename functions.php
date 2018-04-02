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

?>