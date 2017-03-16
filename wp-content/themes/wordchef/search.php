<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordChef
 */

global $wordchef;

get_header();

if ( isset( $wordchef['search-results-layout'] ) && $wordchef['search-results-layout'] == 2 ) { ?>
    <div class="col-xs-12 col-md-9 col-md-push-3">
<?php } else if ( isset( $wordchef['search-results-layout'] ) && $wordchef['search-results-layout'] == 3 ) { ?>
    <div class="col-xs-12 col-md-9">
<?php } else { ?>
    <div class="col-xs-12">
<?php } ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
             
            <?php if ( have_posts() ) : ?>
                <header class="page-header">
                    <div class="results-title">
                        <span class="results-text"><?php printf( esc_html__( 'Search results for %s', 'wordchef' ), '</span>' . get_search_query() . '' ); ?>
                    </div>
                </header><!-- .page-header -->
                    
                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        
                            <?php
                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'content', 'search' );
                            ?>
                    
                    <?php endwhile; ?>

                    <?php if ( $wordchef['pagination'] == 1 ) {
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

<?php if ( isset( $wordchef['search-results-layout'] ) && $wordchef['search-results-layout'] == 2 ) { ?>
    <div class="col-xs-12 col-md-3 col-md-pull-9">  
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } else if ( isset( $wordchef['search-results-layout'] ) && $wordchef['search-results-layout'] == 3 ) { ?>
    <div class="col-xs-12 col-md-3">  
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } ?>

<?php get_footer(); ?>