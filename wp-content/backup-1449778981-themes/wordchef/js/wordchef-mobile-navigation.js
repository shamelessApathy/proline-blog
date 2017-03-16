jQuery(document).ready(function() {
    "use strict";   
    
    // Slide mobile navigation from left
    jQuery('#site-navigation .menu-toggle').on('click', function() {
        jQuery(this).toggleClass('active');
        if ( jQuery(this).hasClass('active') ) {
            jQuery('#site-navigation .menu').animate({left:0}, {duration: 225, easing: 'swing'});
            return false;
        } else {
            jQuery('#site-navigation .menu').animate({left:-291}, {duration: 225, easing: 'linear'});
            return false;
        }
    });
});    