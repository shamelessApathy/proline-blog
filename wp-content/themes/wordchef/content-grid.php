<?php
/**
 * The template part for displaying post grid.
 *
 * @package WordChef
 */
global $wordchef;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
    
    <!-- Featured image -->
    <?php if ( has_post_thumbnail() ) { ?>
        <div class="featured">
            <?php if ( is_single() ) { ?>
                <?php the_post_thumbnail(); ?>
            <?php } else { ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                    <div class="featured-image-wrapper">
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
                        <?php the_post_thumbnail(); ?>
                    </div>
                </a>
            <?php } ?>
        </div>
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
        <div class="post-excerpt">
            <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
        </div>
    </div><!-- .entry-content -->

    <footer class="post-footer">
        <!-- Social media sharing--> 
        <div class="post-social no-gutter col-xs-12">   
            <?php get_template_part( 'inc/social-share' ); ?>
        </div>
    </footer><!-- .entry-footer -->
                
</article><!-- #post-## -->