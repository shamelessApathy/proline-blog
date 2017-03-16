<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordChef
 */
?>

<section class="search-results-page no-results not-found">
	<header class="page-header">
        <span class="results-title">
		  <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'wordchef' ); ?></h1>
        </span>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
        
            <p>
                <?php esc_html_e( 'Ready to publish your first post?', 'wordchef');
                echo '<a href="'. esc_url( admin_url( 'post-new.php' ) ) .'"> ';
                    esc_html_e('Get started here', 'wordchef');
                echo '</a>'; ?>
            </p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again with different keywords.', 'wordchef' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wordchef' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->