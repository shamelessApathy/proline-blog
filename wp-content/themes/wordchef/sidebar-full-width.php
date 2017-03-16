<?php
/**
 * The sidebar containing the footer Instagram widget.
 *
 * @package WordChef
 */

if ( ! is_active_sidebar( 'footer-full-width' ) ) {
	return;
}
?>

<div id="footer-full-width" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'footer-full-width' ); ?>
</div><!-- #secondary -->