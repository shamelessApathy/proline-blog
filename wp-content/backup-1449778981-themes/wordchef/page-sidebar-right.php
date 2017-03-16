<?php
/**
 * Template Name: Sidebar - Right
 *
 * @package WordChef
 */
global $wordchef;

get_header(); ?> 

<div class="page-gutter col-xs-12 col-md-9">
    
    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', 'page' ); ?>


                <?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
        
        <?php
            // If comments are open or we have at least one comment, load up the comment template
            if ( ( comments_open() || get_comments_number() ) && isset($wordchef['page-comments']) && $wordchef['page-comments'] == 1 ) :
                comments_template();
            endif;
        ?>
    </section>

</div><!-- .col -->

<div class="col-xs-12 col-md-3">  
    <?php get_sidebar(); ?>
</div><!-- .col -->

<?php get_footer(); ?>