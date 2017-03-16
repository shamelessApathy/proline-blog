<?php
/**
 * @package WordChef
 */
global $wordchef;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php // Featured image
    if ( has_post_thumbnail() ) { ?>
        <div class="featured">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php } ?>

	<header class="entry-header">
        
        <div class="post-category"><?php echo get_the_category_list(); ?></div>

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="post-title-divider"><span></span></div>

        <div class="post-author-date">
            <span>By <?php the_author_posts_link(); ?></span>
            <span>On <?php wordchef_posted_on(); ?></span>
        </div>
        
        <?php // Get edit post link
        edit_post_link( esc_html__( 'Edit', 'wordchef' ), '<div class="edit-link">', '</div>' ); ?>

    </header><!-- .entry-header -->
        
	<div class="entry-content">
		<?php the_content(); ?>
        
        <?php if ( is_singular( 'post' ) || isset($wordchef['home-post-content']) && $wordchef['home-post-content'] == 1 ) {
			wp_link_pages( array(
				'before'           => '<div class="page-links"><span class="home-post-pages">' . esc_html__( 'Pages', 'wordchef' ).'</span>',
				'after'            => '</div>',
                'link_before'      => '<span class="post-page-nav">',
                'link_after'       => '</span>',
			) );
        } ?>

	</div><!-- .entry-content -->
    
    <?php wordchef_post_tags(); ?>

	<footer class="post-footer">
        <!-- Social media sharing--> 
        <div class="post-social no-gutter col-xs-12">   
            <?php get_template_part( 'inc/social-share' ); ?>
        </div>
    </footer><!-- .entry-footer -->
            
</article><!-- #post-## -->