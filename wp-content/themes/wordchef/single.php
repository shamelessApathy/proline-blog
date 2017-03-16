<?php
/**
 * The template for displaying all single posts.
 *
 * @package WordChef
 */

global $wordchef;

get_header(); 

if ( isset($wordchef['single-post-layout']) && $wordchef['single-post-layout'] == 1 ) { ?>
    <div class="col-xs-12">
<?php } else if ( isset($wordchef['single-post-layout']) && $wordchef['single-post-layout'] == 2 ) { ?>
     <div class="col-xs-12 col-md-9 col-md-push-3">   
<?php } else { ?>
    <div class="col-xs-12 col-md-9"> 
<?php } ?>
    
    <main id="main" class="site-main" role="main">  

        <?php while ( have_posts() ) : the_post(); ?>

            <?php setPostViews(get_the_ID()); ?>

            <?php
            if ( has_post_format( 'aside' )) {
                get_template_part( 'content', 'aside' );
            }
            else if ( has_post_format( 'audio' )) {
                get_template_part( 'content', 'audio' );
            }
            else if ( has_post_format( 'chat' )) {
                get_template_part( 'content', 'chat' );
            }
            else if ( has_post_format( 'gallery' )) {
                get_template_part( 'content', 'gallery' );
            }
            else if ( has_post_format( 'link' )) {
                get_template_part( 'content', 'link' );
            }
            else if ( has_post_format( 'image' )) {
                get_template_part( 'content', 'image' );
            }
            else if ( has_post_format( 'quote' )) {
                get_template_part( 'content', 'quote' );
            }
            else if ( has_post_format( 'status' )) {
                get_template_part( 'content', 'status' );
            }
            else if ( has_post_format( 'video' )) {
                get_template_part( 'content', 'video' );
            }
            else {
                get_template_part( 'content', 'single' );
            }
            ?>

            <!-- About the author -->
            <?php if ( isset($wordchef['author-bio']) && $wordchef['author-bio'] == 1 ) { ?>
                <div id="author-area">
                    <span class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?></span>
                    <div class="author-description">
                        <!-- Added markup from https://www.acceleratormarketing.com/trench-report/google-analytics-errors-and-structured-data/ here to make the author more readable to google
                        specificaaly 'vcard author post-author' to the first span, then added the second span class='fn' -Brian -->
                        <span class="author-name vcard author post-author"><span class='fn'><h3><?php echo get_the_author(); ?></h3></span></span>
                        <!-- To fix the error for not having an updated info area, I added this markup below, nothing existed at all for last updated info for post -Brian -->
                        <span class="post-date updated"><?php the_date(); ?></span>
                        <?php 
                        the_author_meta( 'description' );

                        $author_facebook    = get_the_author_meta('facebook');
                        $author_twitter     = get_the_author_meta('twitter');
                        $author_pinterest   = get_the_author_meta('pinterest');
                        $author_instagram   = get_the_author_meta('instagram');
                        $author_tumblr      = get_the_author_meta('tumblr');
                        $author_google_plus = get_the_author_meta('google+');
                        $author_linkedin    = get_the_author_meta('linkedin');
                        $author_youtube     = get_the_author_meta('youtube');
                        $author_vimeo       = get_the_author_meta('vimeo');

                        ?> 
                        <div class="author-social-profiles"> 
                        <?php
                        if ( !empty($author_facebook) ) { ?>
                            <a href="<?php echo esc_url($author_facebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                        <?php }
                        if ( !empty($author_twitter) ) { ?>
                            <a href="<?php echo esc_url($author_twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                        <?php }
                        if ( !empty($author_pinterest) ) { ?>
                            <a href="<?php echo esc_url($author_pinterest); ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                        <?php }
                        if ( !empty($author_instagram) ) { ?>
                            <a href="<?php echo esc_url($author_instagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                        <?php } 
                        if ( !empty($author_tumblr) ) { ?>
                            <a href="<?php echo esc_url($author_tumblr); ?>" target="_blank"><i class="fa fa-tumblr"></i></a>
                        <?php }
                        if ( !empty($author_google_plus) ) { ?>
                            <a href="<?php echo esc_url($author_google_plus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                        <?php }                                                                
                        if ( !empty($author_linkedin) ) { ?>
                            <a href="<?php echo esc_url($author_linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <?php } 
                        if ( !empty($author_youtube) ) { ?>
                            <a href="<?php echo esc_url($author_youtube); ?>" target="_blank"><i class="fa fa-youtube"></i></a>
                        <?php }
                        if ( !empty($author_vimeo) ) { ?>
                            <a href="<?php echo esc_url($author_vimeo); ?>" target="_blank"><i class="fa fa-vimeo"></i></a>
                        <?php } ?>
                        </div><!--.author-social-profiles-->
                    </div><!--.author-description-->
                </div><!--.author-area-->
            <?php } 

            // Related posts
            wordchef_related_posts();

            // If comments are open or we have at least one comment, load up the comment template
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // end of the loop. ?>

    </main><!-- #main -->

</div><!-- .col -->

<?php if ( isset($wordchef['single-post-layout']) && $wordchef['single-post-layout'] == 2 ) { ?>
    <div class="col-xs-12 col-md-3 col-md-pull-9">
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } else if ( isset($wordchef['single-post-layout']) && $wordchef['single-post-layout'] == 3 ) { ?>
    <div class="col-xs-12 col-md-3">
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } ?>

<?php get_footer(); ?>