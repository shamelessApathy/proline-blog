<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordChef
 */

if ( ! function_exists( 'wordchef_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function wordchef_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
    global $wordchef;
    
    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	?>
	<nav class="col-xs-12 navigation paging-navigation clearfix" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'wordchef' ); ?></h1>
		<div class="nav-links">
            
            <?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-newer">
                <?php if ( isset($wordchef['rtl']) && $wordchef['rtl'] == 1 ) { ?>
                    <h3><?php esc_url( previous_posts_link( '<span class="meta-nav"><i class="fa fa-angle-right"></i></span>'. esc_html__('Newer posts','wordchef') ) ); ?></h3>
                <?php } else { ?>
                    <h3><?php esc_url( previous_posts_link( '<span class="meta-nav"><i class="fa fa-angle-left"></i></span>'. esc_html__('Newer posts','wordchef') ) ); ?></h3>
                <?php } ?>
            </div>
			<?php endif; ?>
            
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-older">
                <?php if ( isset($wordchef['rtl']) && $wordchef['rtl'] == 1 ) { ?>
                    <h3><?php esc_url( next_posts_link( esc_html__('Older posts','wordchef') .'<span class="meta-nav"><i class="fa fa-angle-left"></i></span>' ) ); ?></h3>
                <?php } else { ?>
                    <h3><?php esc_url( next_posts_link( esc_html__('Older posts','wordchef') .'<span class="meta-nav"><i class="fa fa-angle-right"></i></span>' ) ); ?></h3>
                <?php } ?>              
            </div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'wordchef_related_posts' ) ) :
/**
 * Display related posts by category.
 */
function wordchef_related_posts() { 
    
    global $post;
    
    $wpcats = wp_get_post_categories( $post->ID );
    $cats = array();

    foreach ($wpcats as $c) {
         $cats[] = $c;
    }
        
    $args = array(
        'post_type'             => 'post',
        'post_status'           => 'publish',
        'posts_per_page'        => 3,
        'post__not_in'          => array( $post->ID ),
        'category__in'          => $cats,
        'ignore_sticky_posts'   => true,
        'order'                 => 'DESC',
        'order_by'              => 'date',
    );

    $related_posts = new WP_Query($args);
    
    if ( $related_posts->found_posts >= 1 ) { ?>

        <div id="related-posts" class="container-fluid"> 
            <h3 class="related-title"><span>Related Posts</span></h3>
            <div class="post-title-divider"><span></span></div>
            
            <?php while ( $related_posts->have_posts() ) { 
        
                $related_posts->the_post(); ?>
                                             
                <div class="col-xs-12 col-sm-4 related-post">
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
                    <?php the_title( sprintf( '<h3 class="related-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
                    <?php wordchef_posted_on(); ?>
                </div>
            
            <?php } ?>
        </div>
    <?php } 
    
    wp_reset_postdata();
}
endif;

if ( ! function_exists( 'wordchef_cat_links' ) ) :
/**
 * Prints HTML with meta information for post category.
 */
function wordchef_cat_links() {
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( ' ' );
		if ( $categories_list && wordchef_categorized_blog() ) {
			printf( '<div class="cat-links"> %1$s </div>', $categories_list );
		}
	}
}
endif;

if ( ! function_exists( 'wordchef_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wordchef_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>
        <time class="updated-time" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'Y-m-d' ) ),
		esc_html( get_the_date( 'M j, Y' ) ),
		esc_attr( get_the_modified_date( 'Y-m-d' ) ),
		esc_html( get_the_modified_date( 'M j, Y' ) )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'wordchef' ), $time_string 
	);
    
    $format_type = get_post_format();
        if ( false === $format_type ) {
            $format_type = 'standard';
        }
    
    // Get post date
    echo '<div class="posted-on">'. $posted_on .'</div>';
}
endif;

if ( ! function_exists( 'wordchef_post_tags' ) ) :
/**
 * Prints HTML with meta information for the tags.
 */
function wordchef_post_tags() {
    global $wordchef;
    
	// Hide category and tag text for pages. 
	if ( 'post' == get_post_type() && is_singular() && isset($wordchef['post-tags']) && $wordchef['post-tags'] == 1 ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', '', '' );
		if ( $tags_list ) {
			printf( '<span class="tags-links"> %1$s </span>', $tags_list );
		}
	}
}
endif;

if ( ! function_exists( 'wordchef_post_author' ) ) :
// Prints HTML with meta information for author.
function wordchef_post_author() {
    
    $byline = sprintf(
		_x( '%s', 'post author', 'wordchef' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">'. esc_html( get_the_author() ) .'</a></span>'
	);
    
    // Get author name
    echo '<div class="byline">By '. $byline .'</div>';	
}
endif;

if ( ! function_exists( 'wordchef_post_comments' ) ) :
// Prints HTML with meta information for comments.
function wordchef_post_comments() {  
    
    // Get comments number
    echo '<div class="comments-link">';
    comments_popup_link( '0 '. esc_html__('Comments','wordchef'), '1 '.esc_html__('Comment','wordchef'), '% '.esc_html__('Comments','wordchef'), 'comments-link' );
    echo '</div>';	
}
endif;

if ( ! function_exists( 'wordchef_the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 */
function wordchef_the_archive_title() {
	if ( is_category() ) {
		$title = sprintf( '<div class="archive-title"><span>Browsing Category</span> %s </div>', single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( '<div class="archive-title"><span>Browsing Tag</span> %s </div>', single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( '<div class="archive-title"><span>Browsing Author</span> %s </div>', get_the_author() );
	} elseif ( is_year() ) {
		$title = sprintf( '<div class="archive-title"><span>Yearly Archives</span> %s </div>', get_the_date( _x( 'Y', 'yearly archives date format', 'wordchef' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( '<div class="archive-title"><span>Monthly Archives</span> %s </div>', get_the_date( _x( 'F Y', 'monthly archives date format', 'wordchef' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( '<div class="archive-title"><span>Daily Archives</span> %s </div>', get_the_date( _x( 'F j, Y', 'daily archives date format', 'wordchef' ) ) );
	} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$title = _x( 'Archives: Aside', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
		$title = _x( 'Archives: Gallery', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		$title = _x( 'Archives: Image', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		$title = _x( 'Archives: Video', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		$title = _x( 'Archives: Quote', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		$title = _x( 'Archives: Link', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
		$title = _x( 'Archives: Status', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
		$title = _x( 'Archives: Audio', 'post format archive title', 'wordchef' );
	} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
		$title = _x( 'Archives: Chat', 'post format archive title', 'wordchef' );
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'wordchef' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( '%1$s: %2$s', $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'wordchef' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
        echo apply_filters( 'get_the_archive_title', $title );
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wordchef_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wordchef_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wordchef_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 0 ) {
		// This blog has more than 1 category so wordchef_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wordchef_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in wordchef_categorized_blog.
 */
function wordchef_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'wordchef_categories' );
}
add_action( 'edit_category', 'wordchef_category_transient_flusher' );
add_action( 'save_post',     'wordchef_category_transient_flusher' );
