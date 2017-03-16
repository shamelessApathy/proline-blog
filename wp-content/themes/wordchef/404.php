<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package WordChef
 */

global $wordchef;

if ( isset($wordchef['header-style']) && $wordchef['header-style'] == 1 ) {
    get_header(); 
} else {
    get_header('2'); 
} ?>

<div class="page-gutter col-xs-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
                
                <div class="number-404">
                    <h4>404</h4>
                </div>

                <div class="page-content">
                <?php if ( !empty($wordchef['error-404-text']) ) { ?>
                        <p><?php echo esc_html( $wordchef['error-404-text'] ); ?></p>
                <?php } ?>

				    <?php get_search_form(); ?>
          
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
    
		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- .col -->

<?php get_footer(); ?>