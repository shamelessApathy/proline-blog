<?php
/*------------------------------------------------------------------------------------
Featured post meta box
------------------------------------------------------------------------------------*/

/* Fire meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'wordchef_post_meta_box_featured_setup' );
add_action( 'load-post-new.php', 'wordchef_post_meta_box_featured_setup' );

/* Meta box setup function. */
function wordchef_post_meta_box_featured_setup() {

    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action( 'add_meta_boxes', 'wordchef_add_post_meta_box_featured' );
    
    /* Save post meta on the 'save_post' hook. */
    add_action( 'save_post', 'wordchef_save_post_meta_featured', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function wordchef_add_post_meta_box_featured() {

      add_meta_box(
        'wordchef-post-featured',                   // Unique ID
        esc_html__( 'Featured Post', 'wordchef' ),  // Title
        'wordchef_post_featured_meta_box',          // Callback function
        'post',                                     // Admin page (or post type)
        'side',                                     // Context
        'high'                                      // Priority
      );
}

/* Display the post meta box. */
function wordchef_post_featured_meta_box( $object, $box ) { ?>

    <?php wp_nonce_field( basename( __FILE__ ), 'wordchef_post_featured_nonce' ); ?>
    
        <p><?php esc_html_e('Check to make this a featured post','wordchef'); ?></p>
        <p>
        <input class="widefat" type="checkbox" name="wordchef-post-featured" id="wordchef-post-featured" value="1" <?php if ( esc_attr( get_post_meta( $object->ID, 'wordchef_post_featured', true ) ) == 1 ) { ?> checked="checked" <?php } ?> size="30" />
        <label for="wordchef-post-featured"><?php esc_html_e( "Featured Item", 'wordchef' ); ?></label>
        </p>
<?php }

/* Save the meta box's post metadata. */
function wordchef_save_post_meta_featured( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['wordchef_post_featured_nonce'] ) || !wp_verify_nonce( $_POST['wordchef_post_featured_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data. */
  $new_meta_value = ( isset( $_POST['wordchef-post-featured'] ) ? ( $_POST['wordchef-post-featured'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'wordchef_post_featured';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}