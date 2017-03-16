<?php
/**
 * WordChef functions and definitions
 *
 * @package WordChef
 */
require_once get_template_directory() . '/themeoptions/framework.php';   // Redux framework
require_once get_template_directory() . '/themeoptions/options.php';     // Theme options 
require_once get_template_directory() . '/inc/init.php';                 // Initial theme setup
require_once get_template_directory() . '/inc/scripts-and-styles.php';   // Scripts and stylesheets
require_once get_template_directory() . '/inc/blog-pagination.php';      // Numbered blog pagination
require_once get_template_directory() . '/inc/template-tags.php';        // Custom template tags for this theme
require_once get_template_directory() . '/inc/extras.php';               // Custom functions that act independently of the theme templates
require_once get_template_directory() . '/inc/customizer.php';           // Customizer additions
require_once get_template_directory() . '/inc/jetpack.php';              // Load Jetpack compatibility file
require_once get_template_directory() . '/inc/user-social-profiles.php'; // Load user social profiles meta boxes
require_once get_template_directory() . '/inc/mb-featured-post.php';     // Load featured post meta box
require_once get_template_directory() . '/inc/widget-area-setup.php';    // Load widget area setup
require_once get_template_directory() . '/inc/custom-widgets.php';       // Load custom widgets
require_once get_template_directory() . '/inc/fb-opengraph.php';         // Facebook Open Graph meta data
require_once get_template_directory() . '/inc/hit-counter.php';          // Post hit counter
require_once get_template_directory() . '/inc/tgm/tgm-setup.php';        // TGM plugin setup