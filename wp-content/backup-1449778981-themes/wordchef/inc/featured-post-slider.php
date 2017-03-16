<?php global $wordchef; ?>

<?php      
$slider_order = '';
$date_order = '';

if ( isset( $wordchef['featured-posts-order'] ) && $wordchef['featured-posts-order'] == 1 ) { 
    $slider_order = 'date'; 
    $date_order = 'DESC';
} else if ( isset( $wordchef['featured-posts-order'] ) && $wordchef['featured-posts-order'] == 2 ) {
    $slider_order = 'date'; 
    $date_order = 'ASC';

} else if ( isset( $wordchef['featured-posts-order'] ) && $wordchef['featured-posts-order'] == 3 ) {
    $slider_order = 'rand';
    $date_order = '';
}

$args = array(
    'posts_per_page'        => ( isset($wordchef['post-slider-number']) ) ? $wordchef['post-slider-number'] : 6,
    'ignore_sticky_posts'   => true,
    'meta_key'              => 'wordchef_post_featured',
    'meta_value'            => 1,
    'orderby'               => $slider_order,
    'order'                 => $date_order
);

// Meta
$featured_posts = new WP_Query($args);

if ( $featured_posts->found_posts >= 1 ) { ?>

    <!-- full width or boxed -->
    <div class="container-fluid featured-posts-container">

        <div id="featured-posts">
            
            <?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
            
                <div>
                                  
                    <div class="tb">
                        
                        <?php $thumbnail_id = get_post_thumbnail_id( $post->ID );
                        $img = wp_get_attachment_image_src( $thumbnail_id, 'full' ); ?>
                    
                        <a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" class="col-xs-12 col-sm-6 no-gutter tb-cell featured-post-image" style="background-image: url(<?php echo esc_url( $img[0] ); ?>);"></a>

                        <div class="col-xs-12 col-sm-6 tb-cell featured-post-panel">
                            <div class="featured-post-panel-inner">
                                <div class="tb">
                                    <div class="tb-cell">
                                        <div class="featured-post-category"><?php echo get_the_category_list(); ?></div>
                                        <div class="featured-post-title"><h4><a href="<?php esc_url( the_permalink() ); ?>"><?php echo esc_html( the_title() ); ?></a></h4></div>
                                        <div class="post-title-divider"><span></span></div>
                                        <div class="featured-post-excerpt">
                                            <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?> 
                                        </div>
                                        <div class="featured-read-more">
                                            <a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
                                                <?php esc_html_e( 'Read More', 'wordchef' ); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .featured-post-panel-inner -->
   
                            <?php if ( $featured_posts->posts[ $featured_posts->current_post ] == $featured_posts->posts[ 0 ] ) {
                                $prev_post = $featured_posts->posts[ $featured_posts->post_count - 1 ];
                            } else {
                                $prev_post = $featured_posts->posts[ $featured_posts->current_post - 1 ];
                            }   
    
                            if ( !empty( $prev_post ) ) { ?>
                                <span class="featured-post-prev-thumb"><?php echo get_the_post_thumbnail($prev_post->ID, array(450,450)); ?></span>
                            <?php } ?>
                            

                            <?php if ( $featured_posts->posts[ $featured_posts->current_post ] == $featured_posts->posts[ $featured_posts->post_count -1 ] ) {
                                $next_post = $featured_posts->posts[ 0 ];       
                            } else {
                                $next_post = $featured_posts->posts[ $featured_posts->current_post + 1 ];
                            }
    
                            if (!empty( $next_post )) { ?>
                                <span class="featured-post-next-thumb"><?php echo get_the_post_thumbnail($next_post->ID, array(450,450)); ?></span>
                            <?php } ?>
                            
                        </div> <!-- .featured-post-panel -->
                        
                    </div> <!-- .tb -->
                    
                </div> <!-- .slick-slide -->

            <?php endwhile; ?> 

        </div><!-- .featured-posts -->

        <div class="featured-posts-nav col-xs-12 col-sm-6 col-sm-push-6 no-gutter">
            <div class="featured-posts-prev col-xs-6 no gutter">
                <div class="tb">
                    <div class="tb-cell">
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>
            </div>

            <div class="featured-posts-next col-xs-6 no gutter">
                <div class="tb">
                    <div class="tb-cell">
                        <i class="fa fa-angle-up"></i>
                    </div>
                </div>
            </div>
        </div>
        
    </div><!-- .featured-posts-container -->
<?php } ?>