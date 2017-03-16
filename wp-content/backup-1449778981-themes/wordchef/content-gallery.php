<?php
/**
 * @package WordChef
 */
global $wordchef;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
         
    <?php // Featured gallery
    if ( get_post_gallery() ) { ?>
        
        <script type="text/javascript">
            jQuery(document).ready(function() {
                "use strict";
                jQuery('.responsive<?php echo get_the_ID(); ?>').slick({
                    slidesToShow: 1,
                    //Check if rtl enabled
                    <?php if ( isset($wordchef['rtl']) && $wordchef['rtl'] == 1 ) { ?>
                        rtl: true,
                        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-right"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-left"></i></button>',
                    <?php } else { ?>
                        rtl: false,
                        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                    <?php } ?>
                }); 
            });
        </script>
    
        <?php
        $gallery = get_post_gallery( get_the_ID(), false ); 
        $ids = explode( ",", $gallery['ids'] );
        ?>     
        <div class="featured featured-gallery">
            <ul class="responsive<?php echo get_the_ID(); ?>"> 
                <?php
                /* Loop through all the image and output them one by one */
                foreach( $ids as $id ) {
                    $alt_text = get_post_meta($id, '_wp_attachment_image_alt', true); 
                    if ( empty( $alt_text ) ) {
                        $alt_text = get_the_title($id); 
                    } ?>
                    <li>
                        <img src="<?php echo esc_url( wp_get_attachment_url( $id ) ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>" />
                    </li>
                <?php } ?>
            </ul>
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