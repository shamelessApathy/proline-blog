jQuery(document).ready(function() {
    "use strict";
    
    /*---------------------
    Scroll to top button
    ---------------------*/
    // Check top offset when ready
    if ( ( jQuery(window).scrollTop() - jQuery('#masthead').height() ) >= 0 ) {
            jQuery('.scroll-to-top').fadeIn();
        } else {
            jQuery('.scroll-to-top').fadeOut();
        }
    
    // Check top offset while scrolling
    jQuery(window).scroll(function() {
        if ( ( jQuery(window).scrollTop() - jQuery('#masthead').height() ) >= 0 ) {
            jQuery('.scroll-to-top').fadeIn();
        } else {
            jQuery('.scroll-to-top').fadeOut();
        }
    });
    
    // Scroll to top
    jQuery('.scroll-to-top a').on('click', function(e) {
        e.preventDefault();
        jQuery('html,body').animate( { scrollTop: 0 }, 500 );
    });
    
    /*---------------------
    Navigation search button
    ---------------------*/
    // Show search overlay
    jQuery('#masthead .search-toggle').on('click', function() {       
       
        jQuery(this).toggleClass('search-toggle-active');
        if ( jQuery(this).hasClass('search-toggle-active') ) {
            jQuery('.search-toggle-container').animate({width:300}, {duration: 225, easing: 'swing'});
            jQuery('.search-toggle-container .s').focus();
            return false;
        } else {
            jQuery('.search-toggle-container').animate({width:0}, {duration: 225, easing: 'linear'});
            return false;
        }
        
    });

    /*------------------
    Main navigation
    ------------------*/
    // Add toggle button for mobile navigation sub menus
    jQuery('.menu-item-has-children > a').after('<span class="toggle-sub-menu"></span>');
    
    // Mobile nav sub menu toggle button click
    jQuery('#site-navigation .toggle-sub-menu').on('click', function() {
        jQuery(this).toggleClass('toggle-sub-menu-active');
        jQuery(this).next().slideToggle('fast');
    });
    
    // Menu widget sub menu toggle button click
    jQuery('.widget_nav_menu .toggle-sub-menu').on('click', function() {
        jQuery(this).toggleClass('toggle-sub-menu-active');
        jQuery(this).next().slideToggle('fast');
    });
    
    // Add mobile class to menu on load or resize
    if ( jQuery('body').width() <= 1200 ) {
        jQuery('#site-navigation .menu').addClass('mobile-menu');
    }
    jQuery(window).on('resize', function() {
        if ( jQuery('body').width() <= 1200 ) {
            jQuery('#site-navigation .menu').addClass('mobile-menu');
        }
    });
    
    // Hide sub menus on desktop nav on resize
    jQuery(window).on('resize', function() {
        if ( jQuery('body').width() > 1200 ) {
            jQuery('#site-navigation .sub-menu').removeAttr('style');
            jQuery('#site-navigation .toggle-sub-menu-active').removeClass('toggle-sub-menu-active');
            jQuery('#site-navigation .menu').removeClass('mobile-menu');
        }
    });
    
    // Add shadow to fixed nav after scroll
    jQuery(window).scroll(function() {
        if ( jQuery(window).scrollTop() > 0 ) {
            jQuery('#site-navigation.fixed-nav').addClass('nav-shadow');
            jQuery('#site-navigation.fixed-nav .sub-menu').addClass('nav-shadow-sub');
            jQuery('#site-navigation.fixed-nav ~ .search-toggle-container').addClass('nav-shadow-sub');
        } else {
            jQuery('#site-navigation.fixed-nav').removeClass('nav-shadow');
            jQuery('#site-navigation.fixed-nav .sub-menu').removeClass('nav-shadow-sub');
            jQuery('#site-navigation.fixed-nav ~ .search-toggle-container').removeClass('nav-shadow-sub');
        }
    });
    
    /*--------------
    Featured video
    --------------*/
    /* Remove the first iframe in video post 
     * since it has been loaded in the featured container
    */
    var video_posts = jQuery('.type-post.format-video').length; // Count number of video posts
    for ( var i = 0; i < video_posts; i++ ) {
        // Get post-id class for current post in loop
        var video_post_id = jQuery('.type-post.format-video').eq(i).attr('class').split(' ')[0];
        // Move first iframe in post to its featured video container
        jQuery('.'+ video_post_id +' .entry-content iframe').first().unwrap().remove();
    }
    // Reload all audio iframes after moving featured iframe to avoid empty contents
    var video_iframes = jQuery('.format-video .entry-content iframe').length; // Count number of video post iframes
    for ( var i = 0; i < video_iframes; i++ ) {
        // Reload iframe
        jQuery('.type-post.format-video iframe').eq(i).attr('src', jQuery('.type-post.format-video iframe').eq(i).attr('src'));
    }
    
    /*--------------
    Featured audio
    --------------*/
    /* Remove the first iframe in audio post 
     * since it has been loaded in the featured container
    */
    var audio_posts = jQuery('.type-post.format-audio').length; // Count number of audio posts on page
    for ( var i = 0; i < audio_posts; i++ ) {
        // Get post-id class for current post in loop
        var audio_post_id = jQuery('.type-post.format-audio').eq(i).attr('class').split(' ')[0];
        // Move first iframe in post to its featured audio container
        jQuery('.'+ audio_post_id +' .entry-content iframe').first().unwrap().remove();
    }
    // Reload all audio iframes after moving featured iframe to avoid empty contents
    var audio_iframes = jQuery('.type-post.format-audio iframe').length; // Count number of audio post iframes
    for ( var i = 0; i < audio_iframes; i++ ) {
        // Reload iframe
        jQuery('.type-post.format-audio iframe').eq(i).attr('src', jQuery('.type-post.format-audio iframe').eq(i).attr('src'));
    }
    
    /*--------------------------
    FitVids full width videos
    --------------------------*/
    if ( jQuery.fn.fitVids ) {
        jQuery('.hentry').fitVids();
    }

}); /* document ready */

jQuery(window).load(function() {
    "use strict";
  
    /*---------------------
    Loading screen
    ---------------------*/
    jQuery('#loading-screen').fadeOut('medium');
    
});
    
    
    
    
    
    
    
    
    
    
    