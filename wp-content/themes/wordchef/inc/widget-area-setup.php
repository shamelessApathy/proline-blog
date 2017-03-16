<?php 

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wordchef_widgets_init() {
    
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wordchef' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Full width', 'wordchef' ),
		'id'            => 'footer-full-width',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'wordchef' ),
		'id'            => 'footer-widget-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'wordchef' ),
		'id'            => 'footer-widget-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'wordchef' ),
		'id'            => 'footer-widget-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
}

add_action( 'widgets_init', 'wordchef_widgets_init' );