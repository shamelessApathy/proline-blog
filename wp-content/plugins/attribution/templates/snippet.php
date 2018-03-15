<script type="text/javascript">
  window.Attribution=window.Attribution||[];window.Attribution.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","group","track","ready","alias","page","once","off","on"];window.Attribution.factory=function(e){return function(){var t=Array.prototype.slice.call(arguments);t.unshift(e);window.Attribution.push(t);return window.Attribution}};for(var i=0;i<window.Attribution.methods.length;i++){var key=window.Attribution.methods[i];window.Attribution[key]=window.Attribution.factory(key)}window.Attribution.load=function(e){if(document.getElementById("attribution-js"))return;var t=document.createElement("script");t.type="text/javascript";t.id="attribution-js";t.async=true;t.src="//scripts.attributionapp.com/attribution.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(t,n)};window.Attribution.load();
  <?php if ( ! $ignore ) : ?>
    window.Attribution.projectId="<?php echo esc_js( $settings['api_key'] ); ?>";
    window.Attribution.page();
  <?php endif; ?>
</script> 
