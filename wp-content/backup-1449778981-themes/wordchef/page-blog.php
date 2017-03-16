<?php
/**
 * Template Name: Blog
 *
 * @package WordChef
 */
global $wordchef;

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type'             => 'post',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => true,
    'posts_per_page'        => get_option('posts_per_page'),
    'paged'                 => $paged,
);

$my_query = new WP_Query( $args );
?>

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

    <?php if ( $my_query->have_posts() ) : ?>
        
        <?php $counter = 0 ?>
        <?php /* Start the Loop */ ?>
        <?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
                
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
                    <div class="item col-xs-12 col-sm-6 col-md-4">
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

        <?php 
        // Older newer pagination
        // Check if more than 1 page
        if ( isset($wordchef['pagination']) && $wordchef['pagination'] == 1 ) {
            
            if ( $my_query->max_num_pages > 1 ) { ?>   
                <nav class="col-xs-12 navigation paging-navigation clearfix" role="navigation">
                    <h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'wordchef' ); ?></h1>
                    <div class="nav-links">

                        <div class="nav-newer">
                            <?php if ( isset($wordchef['rtl']) && $wordchef['rtl'] == 1 ) { ?>
                                <h3><?php esc_url( previous_posts_link( '<span class="meta-nav"><i class="fa fa-angle-right"></i></span>'. esc_html__('Newer posts','wordchef') ) ); ?></h3>
                            <?php } else { ?>
                                <h3><?php esc_url( previous_posts_link( '<span class="meta-nav"><i class="fa fa-angle-left"></i></span>'. esc_html__('Newer posts','wordchef') ) ); ?></h3>
                            <?php } ?>
                        </div>

                        <div class="nav-older">
                            <?php if ( isset($wordchef['rtl']) && $wordchef['rtl'] == 1 ) { ?>
                                <h3><?php esc_url( next_posts_link( esc_html__('Older posts','wordchef') .'<span class="meta-nav"><i class="fa fa-angle-left"></i></span>', $my_query->max_num_pages ) ); ?></h3>
                            <?php } else { ?>
                                <h3><?php esc_url( next_posts_link( esc_html__('Older posts','wordchef') .'<span class="meta-nav"><i class="fa fa-angle-right"></i></span>', $my_query->max_num_pages ) ); ?></h3>           
                        </div>
                            <?php } ?>

                    </div><!-- .nav-links -->
                </nav><!-- .navigation -->          
            <?php } ?>
                    
        <?php } else {
            // Numbered pagination      
            // Check if more than 1 page
            if( $my_query->max_num_pages > 1 ) {

                $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
                $max   = intval( $my_query->max_num_pages );

                /**	Add current page to the array */
                if ( $paged >= 1 )
                    $links[] = $paged;

                /**	Add the pages around the current page to the array */
                if ( $paged >= 3 ) {
                    $links[] = $paged - 1;
                    $links[] = $paged - 2;
                }

                if ( ( $paged + 2 ) <= $max ) {
                    $links[] = $paged + 2;
                    $links[] = $paged + 1;
                }

                echo '<div class="wordchef-pagination clearfix"><ul>' . "\n";

                /**	Number of pages
                printf( '<li class="page-tracker">Page %s of %s</li>' . "\n", $paged, $max );
                */

                /**	Previous Post Link */
                if ( $wordchef['rtl'] == 1 ) {
                    $prev_arrow = "<i class='fa fa-angle-right'></i>";
                } else {
                    $prev_arrow = "<i class='fa fa-angle-left'></i>";
                }
                if ( get_previous_posts_link() )
                    printf( '<li>%s</li>' . "\n", esc_url( get_previous_posts_link($prev_arrow) ) );

                /**	Link to first page, plus ellipses if necessary */
                if ( ! in_array( 1, $links ) ) {
                    $class = 1 == $paged ? ' class="active"' : '';

                    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

                    if ( ! in_array( 2, $links ) )
                        echo '<li class="pagination-dots">...</li>';
                }

                /**	Link to current page, plus 2 pages in either direction if necessary */
                sort( $links );
                foreach ( (array) $links as $link ) {
                    $class = $paged == $link ? ' class="active"' : '';
                    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
                }

                /**	Link to last page, plus ellipses if necessary */
                if ( ! in_array( $max, $links ) ) {
                    if ( ! in_array( $max - 1, $links ) )
                        echo '<li class="pagination-dots">...</li>' . "\n";

                    $class = $paged == $max ? ' class="active"' : '';
                    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
                }

                /**	Next Post Link */
                if ( $wordchef['rtl'] == 1 ) {
                    $next_arrow = "<i class='fa fa-angle-left'></i>";
                } else {
                    $next_arrow = "<i class='fa fa-angle-right'></i>";
                }
                if ( get_next_posts_link($next_arrow, $my_query->max_num_pages) )
                    printf( '<li>%s</li>' . "\n", esc_url( get_next_posts_link($next_arrow, $my_query->max_num_pages) ) );

                echo '</ul></div>' . "\n";
            
            }
                                               
        } // Blog pagination end ?>

    <?php else : ?>
        <div class="col-xs-12">
             <?php get_template_part( 'content', 'none' ); ?>
        </div>
    <?php endif; wp_reset_query(); ?>

    </main><!-- #main -->

</div><!-- .col -->

<?php // Right sidebar
if ( isset($wordchef['blog-sidebar']) && ($wordchef['blog-sidebar'] == 3) ) { ?>
    <div class="col-xs-12 col-md-3">
    <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php // Left sidebar
} else if ( isset($wordchef['blog-sidebar']) && ($wordchef['blog-sidebar'] == 2) ) { ?> 
    <div class="col-xs-12 col-md-3 col-md-pull-9">
        <?php get_sidebar(); ?>
    </div><!-- .col -->
<?php } ?>
            
<?php get_footer(); ?>