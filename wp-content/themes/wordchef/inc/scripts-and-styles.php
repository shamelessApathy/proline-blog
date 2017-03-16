<?php
/**
 * Enqueue scripts and styles.
 */
function wordchef_scripts() {  
    global $wordchef;
    
    // Main JS
    wp_enqueue_script( 'wordchef-main-js', get_template_directory_uri() . '/js/wordchef-main.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'jquery-masonry' );
    wp_enqueue_script( 'wordchef-featured-posts', get_template_directory_uri() . '/js/wordchef-featured-posts.js', array( 'jquery' ), '1.0.0', true );
    
    // Check if RTL support
	if ( isset($wordchef['rtl']) && $wordchef['rtl'] == 1 ) {
        wp_enqueue_style( 'wordchef-rtl-style', get_template_directory_uri() . '/rtl.css' );
        wp_enqueue_script( 'wordchef-mobile-navigation-rtl', get_template_directory_uri() . '/js/wordchef-mobile-navigation-rtl.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'wordchef-masonry-gallery-rtl', get_template_directory_uri() . '/js/wordchef-gallery-masonry-rtl.js', array( 'jquery' ), '1.0.0', true );
    } else {
        wp_enqueue_style( 'wordchef-style', get_stylesheet_uri() );
        wp_enqueue_script( 'wordchef-mobile-navigation', get_template_directory_uri() . '/js/wordchef-mobile-navigation.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'wordchef-masonry-gallery', get_template_directory_uri() . '/js/wordchef-gallery-masonry.js', array( 'jquery' ), '1.0.0', true );
    }
    
    //Add theme options custom css
    if ( !empty( $wordchef['css-editor'] ) ) {
        wp_enqueue_style( 'wordchef-custom-css', get_template_directory_uri() . '/css/wordchef-custom-css.css' );
        wp_add_inline_style( 'wordchef-custom-css', $wordchef['css-editor'] );
    }
    
    // Check if Lightbox is Enabled
    if ( isset($wordchef['lightbox']) && $wordchef['lightbox'] == 1 ) {
        wp_enqueue_style( 'magnific-popup-css', get_template_directory_uri() . '/css/magnific-popup.css' );
        wp_enqueue_script( 'magnific-popup-js', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'wordchef-magnific-popup-js', get_template_directory_uri() . '/js/wordchef-magnific-popup.js', array( 'jquery' ), '1.0.0', true );
    }
    // Check if Retina is Enabled
	if ( isset($wordchef['retina']) && $wordchef['retina'] == 1 ) {
        wp_enqueue_script( 'wordchef-retina', get_template_directory_uri() . '/js/retina.js', array( 'jquery' ), '1.0.0', true );
    }
    
    wp_enqueue_style( 'bootstrap-grid', get_template_directory_uri() . '/css/bootstrap-grid.css' );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' ); 
    
    wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/css/slick.css' );
    wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick.js', array( 'jquery' ), '1.0.0', true );
    
    wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.0.0', true );
    
	wp_enqueue_script( 'wordchef-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
    
    wp_enqueue_style('thickbox'); // call to media files in wp
    wp_enqueue_script('thickbox');
    wp_enqueue_script( 'media-upload'); 
    
    wp_enqueue_media();

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wordchef_scripts' );

// Add css to wysiwyg editor
function worfchef_admin_styles() {
    global $wordchef;
    
    wp_enqueue_style( 'wordchef-style-admin', get_template_directory_uri() . '/css/wordchef-style-admin.css' );
    // Check if RTL support
	if ( isset($wordchef['rtl']) && $wordchef['rtl'] == 1 ) {
        add_editor_style( '/css/wordchef-editor-style-rtl.css' );
    } else {
        add_editor_style( '/css/wordchef-editor-style.css' );
    }
}
add_action('admin_head', 'worfchef_admin_styles');
add_action('admin_print_styles-widgets.php', 'worfchef_admin_styles');

// Defer Javascripts
// Defer jQuery Parsing using the HTML5 defer property
if (!(is_admin() )) {
    function wordchef_defer_parsing_of_js ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        // return "$url' defer ";
        return "$url' defer onload='";
    }
    add_filter( 'clean_url', 'wordchef_defer_parsing_of_js', 11, 1 );
}