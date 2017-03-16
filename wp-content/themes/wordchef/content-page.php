<?php
/**
 * The template used for displaying page content in page.php
 *
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
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
    
    <div class="post-title-divider"><span></span></div>
        
    <?php // Get edit post link
    edit_post_link( esc_html__( 'Edit', 'wordchef' ), '<div class="edit-link">', '</div>' ); ?>

	<div class="entry-content">
		<?php the_content(); ?>
        
		<?php
			wp_link_pages( array(
				'before'           => '<div class="page-links"><span class="post-pages">' . esc_html__( 'Pages', 'wordchef' ).'</span>',
				'after'            => '</div>',
                'link_before'      => '<span class="post-page-nav">',
                'link_after'       => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="post-footer">   
        <div class="post-social no-gutter col-xs-12">
            <!-- Social media sharing-->    
            <?php get_template_part( 'inc/social-share' ); ?>
        </div> 
	</footer><!-- .entry-footer --> 
    
</article><!-- #post-## -->