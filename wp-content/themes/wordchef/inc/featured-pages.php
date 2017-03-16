<?php global $wordchef; ?>

<?php      
$args = array(
    'posts_per_page'        => -1,
    'post_type'             => 'page',
    'ignore_sticky_posts'   => true,
    'meta_key'              => 'wordchef_page_featured',
    'meta_value'            => 1,
    'order'                 => 'DESC',
    'order_by'              => 'date',
);

$featured_pages = new WP_Query($args);

if ( $featured_pages->found_posts >= 1 ) { ?>

    <!-- full width or boxed -->
    <?php if ( isset($wordchef['layout_type']) && $wordchef['layout_type'] == 1 ) { ?>
        <div class="container-fluid featured-pages-container">
    <?php } else { ?>
        <div class="container featured-pages-container">
    <?php } ?>

        <div id="featured-pages">

            <?php while ( $featured_pages->have_posts() ) : $featured_pages->the_post(); 

                $thumbnail_id = get_post_thumbnail_id( $post->ID );
                $img = wp_get_attachment_image_src( $thumbnail_id, 'full' ); ?>

                <div class="featured-page col-xs-12 col-md-4"> 
                    
                    <a href="<?php esc_url( the_permalink() ); ?>">
                        <div class="featured-page-inner" style="background-image: url(<?php echo esc_url( $img[0] ) ?>);"></div>
                    </a>
                    
                        <div class="featured-page-meta">
                            <div class="featured-page-title">
                                <a href="<?php esc_url( the_permalink() ); ?>">
                                    <?php echo esc_html( the_title() ); ?></div>
                                </a>
                            <div class="featured-page-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></div>
                        </div>
                    
                </div><!-- .featured-page -->

            <?php endwhile; ?>   

        </div><!-- .featured-pages -->
    </div><!-- .featured-pages-container -->
<?php } ?>