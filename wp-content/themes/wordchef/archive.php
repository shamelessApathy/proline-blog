<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordChef
 */

global $wordchef;

get_header(); 

if ( isset( $wordchef['archive-page-layout'] ) && $wordchef['archive-page-layout'] == 2 ) { ?>
    <div class="col-xs-12 col-md-9 col-md-push-3">
<?php } else if ( isset( $wordchef['archive-page-layout'] ) && $wordchef['archive-page-layout'] == 3 ) { ?>
    <div class="col-xs-12 col-md-9">
<?php } else { ?>
    <div class="col-xs-12">
<?php } ?>

        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <?php
                        wordchef_the_archive_title();
                    ?>
                </header><!-- .page-header -->

                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php
                        /* Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'content', 'search' );
                    ?>

                <?php endwhile; ?>

                <?php if ( isset($wordchef['pagination']) && $wordchef['pagination'] == 1 ) {
                    wordchef_paging_nav();
                } else {
                    wordchef_num_nav();
                } ?>

            <?php else : ?>

                <?php get_template_part( 'content', 'none' ); ?>

            <?php endif; ?>

            </main><!-- #main -->
        </div><!-- #primary -->

    </div><!-- .col -->

<?php if ( isset( $wordchef['archive-page-layout'] ) && $wordchef['archive-page-layout'] == 2 ) { ?>
    <div class="col-xs-12 col-md-3 col-md-pull-9">  
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } else if ( isset( $wordchef['archive-page-layout'] ) && $wordchef['archive-page-layout'] == 3 ) { ?>
    <div class="col-xs-12 col-md-3">  
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } ?> 

<?php get_footer(); ?>