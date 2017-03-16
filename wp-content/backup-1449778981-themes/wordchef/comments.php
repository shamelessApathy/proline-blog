<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordChef
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
    
        <h3 class="comments-title">
            <?php
            printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'wordchef' ),
                number_format_i18n( get_comments_number() ), get_the_title() );
            ?>
        </h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wordchef' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'wordchef' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'wordchef' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ul class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
                    'max_depth'   => '4',
                    'avatar_size' => 48,
                    'callback'    => 'wordchef_comment',
				) );
			?>
		</ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wordchef' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'wordchef' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'wordchef' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wordchef' ); ?></p>
	<?php endif; ?>

    <!-- Load comment form -->
    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $comment_args = array(
        
        'title_reply' => '<span>'. esc_html__( 'Leave a Reply', 'wordchef' ) .'</span>',
        
        'comment_notes_before' => '<p class="comment-notes">' .
            esc_html__( 'Your email address will not be published.', 'wordchef' ) .
            '</p>',
        
        'fields'      => apply_filters( 'comment_form_default_fields', array(

            'author' => 
                '<div class="col-xs-12 col-sm-6 comment-form-author">' .
                    '<input id="author" placeholder="'. esc_attr__('Name (required)', 'wordchef') .'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />'.
                '</div>',   

            'email'  => 
                '<div class="col-xs-12 col-sm-6 comment-form-email">' .
                    '<input id="email" placeholder="'. esc_attr__('Email (required)', 'wordchef') .'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />'.
                '</div>' )),

            'comment_field' => 
                '<div class="col-xs-12">' .
                    '<textarea id="comment" placeholder="'. esc_attr__('Comment (required)', 'wordchef') .'" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
                '</div>',

    );

    comment_form($comment_args); ?>

</div><!-- #comments -->