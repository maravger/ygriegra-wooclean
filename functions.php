<?php
function wooclean_child_enqueue_styles() {

    //$parent_style = 'responsive'; 

    //wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );


// get_template_directory_uri() , this equals the parent folder
// get_stylesheet_directory_uri() this would equal the child folder
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	//wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/responsive.css' );
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
add_action( 'wp_enqueue_scripts', 'wpse_enqueue_page_template_styles' );

?>