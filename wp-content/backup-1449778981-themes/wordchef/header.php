<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package WordChef
 */
global $wordchef; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <!-- scroll to top button -->
    <?php if ( isset($wordchef['scroll-button']) && $wordchef['scroll-button'] == 1 ) { ?>
        <div class="scroll-to-top"><a href="#"><i class="fa fa-angle-up"></i></a></div>
    <?php } ?>
    
    <?php if ( isset( $wordchef['loading-screen'] ) && $wordchef['loading-screen'] == 1 ) { ?>
        <div id="loading-screen">
            <div class="tb">
                <div class="tb-cell">
                    <div class="square-container">
                        <div class="square-1"></div>
                        <div class="square-2"></div>
                        <div class="square-3"></div>
                        <div class="square-4"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <div class="container-fluid hfeed site">
        
        <header id="masthead" class="site-header" role="banner"> 
        
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wordchef' ); ?></a>      

            <!-- main navigation -->
            <?php if ( isset($wordchef['fixed-nav']) && $wordchef['fixed-nav'] == 1 ) { ?> 
                <nav id="site-navigation" class="main-navigation fixed-nav" role="navigation">  
            <?php } else { ?>
                <nav id="site-navigation" class="main-navigation" role="navigation">  
            <?php } ?>
                <div class="nav-wrapper">        
                    <a href="#" class="menu-toggle">
                        <span class="bars">
                            <span class="bar bar-1"></span>
                            <span class="bar bar-2"></span>
                            <span class="bar bar-3"></span>
                        </span>
                    </a>

                    <?php wp_nav_menu( array( 'theme_location' => 'wordchef_primary' ) ); ?>

                </div><!-- .nav-wrapper -->
            </nav><!-- #site-navigation -->
                    
            <?php if ( isset($wordchef['search-button']) && $wordchef['search-button'] == 1 ) { ?> 
                <!-- Search button -->
                <a href="#" class="search-toggle"></a>
                <div class="search-toggle-container">
                    <?php get_search_form(); ?>
                </div>
            <?php } ?>

            <!-- Social profiles -->
            <div class="social-nav">
                <div class="tb">
                    <div class="tb-cell">
                        <?php get_template_part( 'inc/topbar-social' ); ?>
                    </div>
                </div>
            </div>
                    
            <!-- Logo or site title and tagline -->
            <div id="site-logo">
                <?php if ( !empty($wordchef['logo']['url']) ) { ?>
                    <a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url( $wordchef['logo']['url'] ); ?>" alt="logo"></a>
                <?php } else { ?>
                    <div class="site-name">
                        <?php if ( is_singular() ) { ?>
                            <h3 class="site-title"><?php echo get_bloginfo('name'); ?></h3>
                            <h4 class="site-description"><?php echo get_bloginfo('description'); ?></h4>
                        <?php } else { ?>
                            <h1 class="site-title"><?php echo get_bloginfo('name'); ?></h1>
                            <h2 class="site-description"><?php echo get_bloginfo('description'); ?></h2>
                        <?php } ?>
                    </div><!-- .site-name -->
                <?php } ?>
            </div><!-- #site-logo -->
      
        </header><!-- #masthead -->

        <!-- Featured post slider -->
        <?php if ( isset($wordchef['featured-posts']) && ( (is_home() || is_page_template( 'page-blog.php' )) && $wordchef['featured-posts'] == 1 ) ) {
            get_template_part( 'inc/featured-post-slider' );
        } ?>
            
        <?php if ( is_home() || is_page_template( 'page-blog.php' ) ) {
            get_template_part( 'inc/featured-pages' ); 
        } ?>
        
    <!-- Site layout type, full width or boxed -->
    <?php if ( isset($wordchef['layout_type']) && $wordchef['layout_type'] == 1 ) { ?>
        <div id="wrap" class="container-fluid">
            <div id="content" class="site-content">  
    <?php } else { ?>
        <div id="wrap">
            <div id="content" class="site-content container">  
    <?php } ?>      