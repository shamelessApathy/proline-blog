<?php
/**
 * The template part for displaying post list.
 *
 * @package WordChef
 */
global $wordchef;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('list-item'); ?>>
    
    <div class="tb">
        
    <!-- Featured image -->
    <?php if ( has_post_thumbnail() ) { ?>
        
        <?php // Get post thumbnail
        $thumbnail_id = get_post_thumbnail_id( $post->ID );
        $img = wp_get_attachment_image_src( $thumbnail_id, 'full' ); ?>
        
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="no-gutter col-xs-12 col-sm-5 list-image tb-cell" style="background-image: url(<?php echo esc_url( $img[0] ); ?>);">
            <span class="image-line-top"></span>
            <span class="image-line-right"></span>
            <span class="image-line-bottom"></span>
            <span class="image-line-left"></span>
            <span class="image-plus">
                <div class="tb">
                    <div class="tb-cell">
                        <i class="fa fa-plus"></i>
                    </div>
                </div>
            </span>
        </a>
             
        <div class="list-content no-gutter col-xs-12 col-sm-7 tb-cell">
                
    <?php } else { ?>
        <div class="list-content no-gutter col-xs-12 tb-cell">
    <?php } ?>
            
            <header class="entry-header">
        
                <div class="post-category"><?php echo get_the_category_list(); ?></div>

                <?php //Check if post is singular
                if ( is_single() ) { 
                   the_title( '<h1 class="entry-title">', '</h1>' );
                } else {
                    the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
                } ?>

                <div class="post-title-divider"><span></span></div>

                <div class="post-author-date">
                    <span>By <?php the_author_posts_link(); ?></span>
                    <span>On <?php wordchef_posted_on(); ?></span>
                </div>

                <?php // Get edit post link
                edit_post_link( esc_html__( 'Edit', 'wordchef' ), '<div class="edit-link">', '</div>' ); ?>

            </header><!-- .entry-header -->
            
            <div class="entry-content">
                <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>    
            </div><!-- .entry-content -->
                        
            <footer class="post-footer">
                <!-- Social media sharing--> 
                <div class="post-social no-gutter col-xs-12">   
                    <?php get_template_part( 'inc/social-share' ); ?>
                </div>
            </footer><!-- .entry-footer -->
            
        </div>
                
        </div>
        
</article><!-- #post-## -->