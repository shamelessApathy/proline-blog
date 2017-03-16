<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordChef
 */

global $wordchef;

get_header(); ?>

<?php // Right sidebar layout
if ( isset($wordchef['blog-sidebar']) && $wordchef['blog-sidebar'] == 3 ) { ?>
    <div class="no-gutter col-xs-12 col-md-9">
<?php // Left sidebar layout
} else if ( isset($wordchef['blog-sidebar']) && $wordchef['blog-sidebar'] == 2 ) { ?>
    <div class="no-gutter col-xs-12 col-md-9 col-md-push-3">
<?php // Full width layout
} else { ?>
    <div class="no-gutter col-xs-12">
<?php } ?>
        
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>
        
        <?php $counter = 0 ?>
        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
                
            <?php // Check if first full post
            if ( $counter == 0 && isset($wordchef['blog-layout']) && ($wordchef['blog-layout'] == 5 || $wordchef['blog-layout'] == 6 || $wordchef['blog-layout'] == 7) ) { ?>
                <div class="col-xs-12">
                    <?php get_template_part( 'content', get_post_format() ); ?>
                </div>
            <?php } else { ?> 
        
                <?php // 1 Column
                if ( isset($wordchef['blog-layout']) && ($wordchef['blog-layout'] == 1 || $wordchef['blog-layout'] == 2 || $wordchef['blog-layout'] == 5) ) { ?>  
                    <div class="col-xs-12">
                <?php // 2 Columns
                } else if ( isset($wordchef['blog-layout']) && ($wordchef['blog-layout'] == 3 || $wordchef['blog-layout'] == 6) ) { ?>
                    <div class="col-xs-12 col-sm-6">
                <?php // 3 Columns
                } else if ( isset($wordchef['blog-layout']) && ($wordchef['blog-layout'] == 4 || $wordchef['blog-layout'] == 7) ) { ?>
                    <div class="item col-xs-12 col-md-4">
                <?php // else 1 column
                } else { ?>
                    <div class="col-xs-12">
                <?php } ?>

                        <?php
                        // List posts
                        if ( isset($wordchef['blog-layout']) && ($wordchef['blog-layout'] == 2 || $wordchef['blog-layout'] == 5) ) {
                            get_template_part( 'content', 'list' );
                        } else if ( isset($wordchef['blog-layout']) && ($wordchef['blog-layout'] == 3 || $wordchef['blog-layout'] == 4 || $wordchef['blog-layout'] == 6 || $wordchef['blog-layout'] == 7) ) { 
                            // Grid posts
                            get_template_part( 'content', 'grid' );
                        } else { // Standard posts
                            get_template_part( 'content', get_post_format() );
                        } ?>

                </div><!-- closing div for column layout -->

            <?php } // if 1st full post
            
            // New line for full post + 2 column grid layout
            if ( ($counter != 0 && $counter % 2 == 0) && (isset($wordchef['blog-layout']) && $wordchef['blog-layout'] == 6) ) {
                echo '<div class="col-xs-12"></div>';
            }    
            // New line for full post + 3 column grid layout
            if ( ($counter != 0 && $counter % 3 == 0) && (isset($wordchef['blog-layout']) && $wordchef['blog-layout'] == 7) ) {
                echo '<div class="col-xs-12"></div>';
            }
             
            // Post counter
            $counter++;
                        
            // New line for 2 column grid layout
            if ( $counter % 2 == 0 && (isset($wordchef['blog-layout']) && $wordchef['blog-layout'] == 3) ) {
                echo '<div class="col-xs-12"></div>';
            }    
            // New line for 3 column grid layout
            if ( $counter % 3 == 0 && (isset($wordchef['blog-layout']) && $wordchef['blog-layout'] == 4) ) {
                echo '<div class="col-xs-12"></div>';
            } ?>

        <?php endwhile; ?>

        <?php if ( isset($wordchef['pagination']) && $wordchef['pagination'] == 1 ) {
            wordchef_paging_nav();
        } else {
            wordchef_num_nav();
        } ?>

    <?php else : ?>
        <div class="col-xs-12">
             <?php get_template_part( 'content', 'none' ); ?>
        </div>
    <?php endif; ?>

    </main><!-- #main -->

</div><!-- .col -->

<?php // Right sidebar
if ( isset($wordchef['blog-sidebar']) && ($wordchef['blog-sidebar'] == 3) ) { ?>
    <div class="col-xs-12 col-md-3">
    <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php // Left sidebar
} else if ( isset($wordchef['blog-sidebar']) && ($wordchef['blog-sidebar'] == 2) ) { ?> 
    <div class="col-xs-12 col-md-4 col-md-pull-9">
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } ?>
            
<?php get_footer(); ?>         