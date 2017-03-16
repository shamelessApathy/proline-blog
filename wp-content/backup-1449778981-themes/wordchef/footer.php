<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordChef
 */
global $wordchef; ?>

</div><!-- #content -->
</div><!-- #wrap -->

<footer id="colophon" class="container-fluid site-footer" role="contentinfo">

    <?php get_sidebar('footer'); ?>
    
    <?php get_sidebar('full-width'); ?>

    <div class="container-fluid site-info">
        <div class="container">    
            
            <?php if ( !empty($wordchef['footer-logo']['url']) ) { ?>
                <div id="footer-logo">
                    <a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url( $wordchef['footer-logo']['url'] ); ?>" alt="footer-logo"></a>
                </div>
            <?php } ?>
            
            <?php if ( !empty($wordchef['footer-text']) ) {
                echo wp_kses( $wordchef['footer-text'], 'span, div, class, id, a, em, i, strong, del, b, ul, ol, li, img, h1, h2, h3, h4, h5, h6' );
            }?>
        </div><!-- .site-info -->
    </div><!-- .container --> 
    
    <?php if ( $wordchef['social-footer'] == 1 ) {
        get_template_part( 'inc/footer-social' );
     } ?>
    
</footer><!-- #colophon -->

</div><!-- .hfeed .site -->

<?php wp_footer(); ?>
</body>
</html>