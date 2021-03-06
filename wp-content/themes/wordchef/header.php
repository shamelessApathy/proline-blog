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
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PLZBRT');</script>
    <!-- End Google Tag Manager -->

<!--Autopilot Tracking -->
<script type="text/javascript">(function(o){var b="https://api.autopilothq.com/anywhere/",t="be86034d3bb44e17afd76f1f2d14ff719d9670f3c3c940d88913de3dbc96fd96",a=window.AutopilotAnywhere={_runQueue:[],run:function(){this._runQueue.push(arguments);}},c=encodeURIComponent,s="SCRIPT",d=document,l=d.getElementsByTagName(s)[0],p="t="+c(d.title||"")+"&u="+c(d.location.href||"")+"&r="+c(d.referrer||""),j="text/javascript",z,y;if(!window.Autopilot) window.Autopilot=a;if(o.app) p="devmode=true&"+p;z=function(src,asy){var e=d.createElement(s);e.src=src;e.type=j;e.async=asy;l.parentNode.insertBefore(e,l);};y=function(){z(b+t+'?'+p,true);};if(window.attachEvent){window.attachEvent("onload",y);}else{window.addEventListener("load",y,false);}})({});</script>
<!--End of Autopilot Tracking -->

</head>

<body <?php body_class(); ?>>
<script>
  fbq('track', 'ViewContent');
</script>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PLZBRT"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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