<?php
/**
 * @package WordChef
 */
global $wordchef;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php //Get the first embedded video
    $content = apply_filters( 'the_content', get_the_content() );
    $embed = get_media_embedded_in_content ( $content, array('iframe') );
    if ( !empty($embed[0]) ) { // Check if embedded video exists ?>
        <div class="featured featured-video">
            <?php echo ($embed[0]); // Display the first embedded video ?>
        </div>
    <?php } else { // Display featured image ?>
        <div class="featured">
            <?php if ( is_single() ) { ?>
                <?php the_post_thumbnail(); ?>
            <?php } else { ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                    <?php the_post_thumbnail(); ?>
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
    
    <?php wordchef_post_tags(); ?>

    <footer class="post-footer">
        <!-- Social media sharing--> 
        <div class="post-social no-gutter col-xs-12">   
            <?php get_template_part( 'inc/social-share' ); ?>
        </div>
    </footer><!-- .entry-footer -->
            
</article><!-- #post-## -->