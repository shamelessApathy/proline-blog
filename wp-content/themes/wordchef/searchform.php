<form action="<?php echo esc_url( home_url('/') ); ?>" method="get">
	<fieldset>
		<input type="text" name="s" class="s" placeholder="<?php esc_html_e('Type and hit enter...', 'wordchef'); ?>" value="<?php the_search_query(); ?>" />
        <button type="submit" class="widget-search" value="search"><?php esc_html_e('Search','wordchef'); ?></button>
	</fieldset>
</form>