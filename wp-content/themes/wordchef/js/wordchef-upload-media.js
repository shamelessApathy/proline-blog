jQuery(document).ready(function() {
    "use strict";
    
    /*----------------------
    About Me widget Upload
    ----------------------*/
    jQuery(document).on("click", ".about_me_media_upload", function(e) {
        e.preventDefault();

        var about_me_uploader = wp.media({
            title: 'Select About Me Image',
            button: {
                text: 'Confirm'
            },
            multiple: 'false'  // Set this to true to allow multiple files to be selected
        })
        .on('select', function() {

            jQuery(".about_me_media_id").val("");
            jQuery(".about_me_preview").empty();

            var selection = about_me_uploader.state().get('selection');
                selection.map( function( attachment ) {
                attachment = attachment.toJSON();     

                jQuery(".about_me_media_id").val( jQuery(".about_me_media_id").val() + attachment.id);  
                jQuery(".about_me_preview").append('<img src="'+attachment.url+'" width="100%" alt="'+attachment.id+'" title="'+attachment.id+'"/>');  
                 
                // Trigger input change to activate widget save button
                jQuery('.about_me_media_id').trigger('change');
            })                

        })
        .open();
    });
    
    // Remove button
    jQuery(document).on("click", ".about_me_media_remove", function() { 
        jQuery(".about_me_media_id").val("");
        jQuery(".about_me_preview").empty();
        
        // Trigger input change to activate widget save button
        jQuery('.about_me_media_id').trigger('change');
    });
    
    
    /*------------------
    Image widget Upload
    ------------------*/
    jQuery(document).on("click", ".image_media_upload", function(e) {
        e.preventDefault();

        var image_uploader = wp.media({
            title: 'Select an Image',
            button: {
                text: 'Confirm'
            },
            multiple: 'false'  // Set this to true to allow multiple files to be selected
        })
        .on('select', function() {

            jQuery(".image_media_id").val("");
            jQuery(".image_preview").empty();

            var selection = image_uploader.state().get('selection');
                selection.map( function( attachment ) {
                attachment = attachment.toJSON();     

                jQuery(".image_media_id").val( jQuery(".image_media_id").val() + attachment.id);  
                jQuery(".image_preview").append('<img src="'+attachment.url+'" width="100%" alt="'+attachment.id+'" title="'+attachment.id+'"/>');  
                 
                // Trigger input change to activate widget save button
                jQuery('.image_media_id').trigger('change');
            })                

        })
        .open();
    });
    
    // Remove button
    jQuery(document).on("click", ".image_media_remove", function() { 
        jQuery(".image_media_id").val("");
        jQuery(".image_preview").empty();
        
        // Trigger input change to activate widget save button
        jQuery('.image_media_id').trigger('change');
    });
    
});