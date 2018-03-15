<script type="text/javascript">
	Attribution.identify( <?php echo '"' . esc_js( $user_id ) . '"' ?><?php if ( ! empty( $traits ) ) { echo ', ' . json_encode( Attribution_Analytics_WordPress::esc_js_deep( $traits ) ); } else { echo ', {}'; } ?><?php if ( ! empty( $options ) ) { echo ', ' . json_encode( Attribution_Analytics_WordPress::esc_js_deep( $options ) ); } ?>);
</script>
