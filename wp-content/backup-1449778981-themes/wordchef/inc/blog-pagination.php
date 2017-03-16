<?php
// Numbered Pagination
if ( !function_exists( 'wordchef_num_nav(') ) {
	
	function wordchef_num_nav() {

	if( is_singular() )
		return;

	global $wp_query;
    global $wordchef;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

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
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", esc_url( get_next_posts_link($next_arrow) ) );

	echo '</ul></div>' . "\n";

    }	
}