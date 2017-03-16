jQuery(document).ready(function() {
    "use strict"; 
    /*--------------------
    Masonry gallery setup
    --------------------*/
    // Masonry media gallery
    jQuery('.gallery').imagesLoaded(function() {
        jQuery('.gallery').masonry({
            percentPosition: true,
            columnWidth: '.gallery-item',
            itemSelector: '.gallery-item',
            isRTL: true,
        });
    });
});