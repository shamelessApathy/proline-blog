<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @package WordChef
 */
global $wordchef;

if ( ! is_active_sidebar( 'footer-widget-1' ) && ! is_active_sidebar( 'footer-widget-2' ) && ! is_active_sidebar( 'footer-widget-3' ) ) {
	return;
}
?>

<!-- full width or boxed -->
<?php if ( isset($wordchef['layout_type']) && $wordchef['layout_type'] == 1 ) { ?>
    <div class="container-fluid footer-widgets">
<?php } else { ?>
    <div class="container footer-widgets">
<?php } ?>


    <!-- Footer widget column 1 -->
    <div id="footer-widget-1" class="widget-area col-xs-12 col-md-4" role="complementary">
        <?php dynamic_sidebar( 'footer-widget-1' ); ?>
    </div><!-- #secondary -->

    <!-- Footer widget column 2 -->
    <div id="footer-widget-2" class="widget-area col-xs-12 col-md-4" role="complementary">
        <?php dynamic_sidebar( 'footer-widget-2' ); ?>
    </div>

    <!-- Footer widget column 3 -->
    <div id="footer-widget-3" class="widget-area col-xs-12 col-md-4" role="complementary">
        <?php dynamic_sidebar( 'footer-widget-3' ); ?>
    </div>
    
</div>