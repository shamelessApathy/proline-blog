/*------------------
Image Lightbox
------------------*/
jQuery(document).ready(function(){
    "use strict";
    
    // Single media attachment lightbox 
    // Exclude custom url attachments
    jQuery('.entry-content a img:not(.entry-content .gallery a img, .entry-content .custom-url img)').parent().each(function() {
        jQuery(this).magnificPopup({
            type: 'image',
            closeBtnInside: true,
            closeMarkup: '<i class="mfp-close fa fa-times"></i>',
            mainClass: 'mfp-fade',
            
            image: { 
                cursor:'cursor-default',
                titleSrc: function(item) {
                    return item.el.next('figcaption').html();
                },
            },
            
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function 

                // The "opener" function should return the element from which popup will be zoomed in
                // and to which popup will be scaled down
                // By defailt it looks for an image tag:
                opener: function(openerElement) {
                    // openerElement is the element on which popup was initialized, in this case its <a> tag
                    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            },
        });
    });
    
    // Media gallery lightbox
    jQuery('.entry-content .gallery').each(function() {
        jQuery(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            closeBtnInside: true,
            closeMarkup: '<i class="mfp-close fa fa-times"></i>',
            mainClass: 'mfp-fade',
            
            image: { 
                cursor:'cursor-default',
                titleSrc: function(item) {
                    if ( jQuery.trim( item.el.next('figcaption').html() ) != '' ) {
                        return item.el.next('figcaption').html();
                    } else {
                        return '';
                    }
                },
            },
            
            gallery: {
                enabled: true,

                preload: [0,2], // read about this option in next Lazy-loading section

                navigateByImgClick: true,

                arrowMarkup: '<button type="button" title="%title%" class="mfp-arrow mfp-arrow-%dir%"></button>', 

                tPrev: 'Previous (Left arrow key)', // title for left button
                tNext: 'Next (Right arrow key)', // title for right button
                tCounter: '<span class="mfp-counter">%curr% of %total%</span>',
            },
            
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function 

                // The "opener" function should return the element from which popup will be zoomed in
                // and to which popup will be scaled down
                // By defailt it looks for an image tag:
                opener: function(openerElement) {
                    // openerElement is the element on which popup was initialized, in this case its <a> tag
                    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            },
        });
    });

});