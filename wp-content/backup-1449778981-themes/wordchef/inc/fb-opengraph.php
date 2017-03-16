<?php
function fb_opengraph() {
    global $wordchef;
    global $post;
 
    if ( is_single() ) {
        if ( has_post_thumbnail($post->ID) ) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        } elseif ( !empty($wordchef['logo']['url']) ) {
            $img_src = $wordchef['logo']['url'];
        }
        if ( $excerpt = $post->post_excerpt ) {
            $excerpt = strip_tags( $post->post_excerpt );
            $excerpt = str_replace( "", "'", $excerpt );
        } else if ( $excerpt = $post->post_content ) {
            $excerpt = strip_tags( $post->post_content );
            $excerpt = strip_shortcodes( $excerpt );
            $excerpt = str_replace( "", "'", $excerpt );
            $excerpt = substr( $excerpt, 0, 300 ).'...';
        } else {
            $excerpt = get_bloginfo( 'description' );
        }
        ?>
 
    <meta property="og:title" content="<?php echo esc_attr( the_title() ); ?>"/>
    <meta property="og:description" content="<?php echo esc_attr( $excerpt ); ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php echo esc_url( the_permalink() ); ?>"/>
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
    <meta property="og:image" content="<?php echo esc_url( $img_src[0] ); ?>"/>
    <meta property="og:image:width" content="<?php echo esc_url( $img_src[1] ); ?>" /> 
    <meta property="og:image:height" content="<?php echo esc_url( $img_src[2] ); ?>" />
 
<?php
    } else {
        return;
    }
}
add_action('wp_head', 'fb_opengraph', 5);