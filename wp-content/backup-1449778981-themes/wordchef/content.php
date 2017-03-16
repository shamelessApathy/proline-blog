<?php
/**
 * @package WordChef
 */
global $wordchef;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <!-- Featured image -->
    <?php if ( has_post_thumbnail() ) { ?>
        <div class="featured">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
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
            </a>
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
            By <?php the_author_posts_link(); ?> On <?php wordchef_posted_on(); ?>
        </div>
        
        <?php // Get edit post link
        edit_post_link( esc_html__( 'Edit', 'wordchef' ), '<div class="edit-link">', '</div>' ); ?>

    </header><!-- .entry-header -->
    
    <div class="entry-content">
        <?php
        if ( isset($wordchef['home-post-content']) && $wordchef['home-post-content'] == 1 && !( has_excerpt() ) ) {
            the_content();
        } else {
            if ( is_singular( 'post' ) ) {
                the_content();
            } else { ?>
                <div class="post-excerpt">
                    <?php the_excerpt(); ?>
                </div> <?php 
            }
        }
        ?>

        <!-- Get read more button if more tag used or excerpt -->
        <?php if( !( is_singular( 'post' ) ) && strstr($post->post_content,'<!--more-->') || (!( is_singular( 'post' ) ) && isset($wordchef['home-post-content']) && $wordchef['home-post-content'] == 2) || ( has_excerpt() ) ) {
            /* translators: %s: Name of current post. Visible to screen readers only. */
            echo '<div class="read-more-link"><a href="'. esc_url( get_permalink( get_the_ID() ) ) .'">
            '.sprintf(
                esc_html( $wordchef['read-more-text'] ) .' %s',
                the_title( '<span class="screen-reader-text">"', '</span>', false )
            ).'
            </a></div>';
         } ?>

        <?php if ( is_singular( 'post' ) || isset($wordchef['home-post-content']) && $wordchef['home-post-content'] == 1 ) {
            wp_link_pages( array(
                'before'           => '<div class="page-links"><span class="home-post-pages">' . esc_html__( 'Pages', 'wordchef' ).'</span>',
                'after'            => '</div>',
                'link_before'      => '<span class="post-page-nav">',
                'link_after'       => '</span>',
            ) );
        } ?>

    </div><!-- .entry-content -->

    <footer class="post-footer">
        <!-- Social media sharing--> 
        <div class="post-social no-gutter col-xs-12">   
            <?php get_template_part( 'inc/social-share' ); ?>
        </div>
    </footer><!-- .entry-footer -->
                    
</article><!-- #post-## -->