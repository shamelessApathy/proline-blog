<?php

if ( ! function_exists( 'wordchef_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wordchef_setup() {
    
    global $wordchef; 
    
    // Set the content width based on the theme's design and stylesheet.
    if ( ! isset( $content_width ) ) {
        $content_width = 1140; /* pixels */
    }
    
    /*
     * Add theme options google fonts to TinyMCE post editor
     */
    if ( !empty( $wordchef['body-typography']['font-family'] ) ) {
        $google_font_body = str_replace( ' ', '+', $wordchef['body-typography']['font-family'] );
        $font_url_body = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family='. $google_font_body .':300,400,700' );
        add_editor_style( $font_url_body );
    }
    
    if ( !empty( $wordchef['heading-typography']['font-family'] ) ) {
        $google_font_headings = str_replace( ' ', '+', $wordchef['heading-typography']['font-family'] ); 
        $font_url_headings = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family='. $google_font_headings .':300,400,700' );
        add_editor_style( $font_url_headings );
    }
    
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'wordchef', get_template_directory() . '/languages' );   
    /*
     * If your translated language is not available in settings > general > site languages,
     * define it below. Replace en_US with your county's language 'WP Locale',
     * which can be found here: https://make.wordpress.org/polyglots/teams/
     * Now you will be able to find you language in settings > general > site languages.
     */
    //define ('WPLANG', 'en_US');

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    
	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'wordchef_primary', esc_html__( 'Primary Menu', 'wordchef' ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
      
    add_theme_support( 'post-formats', array(
		'audio', 'gallery', 'video'
	) );

}
endif; // wordchef_setup
add_action( 'after_setup_theme', 'wordchef_setup' );


/*---------------- 
Custom comment
----------------*/	
function wordchef_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo esc_html( $tag ) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf( '<cite class="fn">%s</cite> <span class="says">'. esc_html__('says:', 'wordchef') .'</span>', get_comment_author_link() ); ?>
	</div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'wordchef'); ?></em>
		<br />
	<?php endif; ?>

	<div class="comment-meta comment-metadata">
		<?php
			/* translators: 1: date, 2: time */
			printf( '%1$s', get_comment_date() ); ?><?php edit_comment_link( esc_html__('Edit', 'wordchef'), '  ', '' );
		?>
	</div>

	<?php comment_text(); ?>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/*---------------- 
Read more excerpt
----------------*/
function wordchef_new_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'wordchef_new_excerpt_more');

/*------------- 
Excerpt length
-------------*/
function wordchef_custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'wordchef_custom_excerpt_length', 999 );

/*--------------------------- 
Categories widget post count
---------------------------*/
function wordchef_categories_postcount_filter ($variable) {
    $variable = str_replace('(', '<span class="categories-post-count">', $variable);
    $variable = str_replace(')', '</span>', $variable);
    return $variable;
}
add_filter('wp_list_categories','wordchef_categories_postcount_filter');

/*------------------------- 
Archives widget post count
-------------------------*/
function wordchef_archive_postcount_filter ($variable) {
    $variable = str_replace('(', '<span class="archives-post-count">', $variable);
    $variable = str_replace(')', '</span>', $variable);
    return $variable;
}
add_filter('get_archives_link', 'wordchef_archive_postcount_filter');

/*------------------ 
Custom post gallery
------------------*/
function wordchef_post_gallery($output, $attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';

	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class = sanitize_html_class( $atts['size'] );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}
		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output";
                
                if ( $captiontag && trim($attachment->post_excerpt) ) {
                    $output .= "
                        <{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
                        " . wptexturize($attachment->post_excerpt) . "
                        </{$captiontag}>";
                }
                
        $output .= "</{$icontag}>";
		$output .= "</{$itemtag}>";
		if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

	$output .= "
		</div>\n";

	return $output;
}

add_filter('post_gallery', 'wordchef_post_gallery', 10,4);