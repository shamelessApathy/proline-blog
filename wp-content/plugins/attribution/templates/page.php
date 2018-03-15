 <script type="text/javascript">
  Attribution.page(<?php echo '"' . esc_js( $category ) . '"' ?><?php if ( ! empty( $name ) ) echo ', "' . esc_js( $name ) . '"' ?><?php if ( ! empty( $properties ) ) { echo ', ' . json_encode( Attribution_Analytics_WordPress::esc_js_deep( $properties ) ); } else { echo ', {}'; } ?><?php if ( ! empty( $options ) ) { echo ', ' . json_encode( Attribution_Analytics_WordPress::esc_js_deep( $options ) ); } ?>);
 <?php
  	if ( $http_event ) :
  		?>
		attribution.ajaxurl = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>",

		jQuery( document ).ready( function( $ ) {
			var data = {
				action : 'attribution_unset_cookie',
				key    : '<?php echo esc_js( $http_event ); ?>',

			},
			success = function( response ) {
				console.log( response );
			};

			$.post( attribution.ajaxurl, data, success );
		});

  		<?php
	endif;
  ?>
</script>
