/*--------------------
Featured Post Slider
--------------------*/
jQuery(document).ready(function() {
    "use strict";
    
    jQuery('#featured-posts').slick({
        slidesToShow: 1,
        swipe: false,
        vertical: true,
        arrows: false,
    });
    
    jQuery('.featured-posts-next').click(function(){
        jQuery("#featured-posts").slick('slickNext');
        
        if ( jQuery('#featured-posts').slick('getSlick').slideCount > 2 ) {  
            jQuery('.featured-posts-next').css('background-image', 'url(' + jQuery('.slick-current .featured-post-next-thumb img').attr('src') + ')');
            jQuery('.featured-posts-prev').css('background-image', 'url(' + jQuery('.slick-current .featured-post-prev-thumb img').attr('src') + ')');
        }
        
    });
    
    jQuery('.featured-posts-prev').click(function(){
        jQuery("#featured-posts").slick('slickPrev');
        
        if ( jQuery('#featured-posts').slick('getSlick').slideCount > 2 ) {  
            jQuery('.featured-posts-next').css('background-image', 'url(' + jQuery('.slick-current .featured-post-next-thumb img').attr('src') + ')');
            jQuery('.featured-posts-prev').css('background-image', 'url(' + jQuery('.slick-current .featured-post-prev-thumb img').attr('src') + ')');
        }
        
    });
    
    if ( jQuery('#featured-posts').slick('getSlick').slideCount > 2 ) {      
        jQuery('.featured-posts-next').css('background-image', 'url(' + jQuery('.slick-current .featured-post-next-thumb img').attr('src') + ')');
        jQuery('.featured-posts-prev').css('background-image', 'url(' + jQuery('.slick-current .featured-post-prev-thumb img').attr('src') + ')');
    }
    
});