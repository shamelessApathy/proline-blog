<?php

/*
    Plugin Name: Content Unlocked Recipes

    Plugin URI: 

    Description: Easily add delicious recipes (with color images) to your website or blog, for FREE! Developed & tested by experts. NO ads, NO kidding.

    Author: Contentoro 

    Author URI: http://www.contentoro.com/Content-Unlocked

    Version: 1.0.2

    This is Contentoro ContentUnlocked Plugin

*/

require_once 'contentunlockedrecipes.class.php';

function register_ContentUnlockedRecipes_widget(){

	register_widget('ContentUnlockedRecipes');

}

add_action('widgets_init','register_ContentUnlockedRecipes_widget');



function ContentUnlocked_RECIPES_settings_init()
{    
	register_setting('general', 'ContentUnlocked_RECIPES_apikey');
 

	add_settings_section(
		'ContentUnlocked_RECIPES_settings_section',
		'',
		'ContentUnlocked_RECIPES_settings_section_cb',
		'general'
	);
 
	add_settings_field(
		'ContentUnlocked_RECIPES_settings_field',
		'ContentUnlocked_RECIPES',
		'ContentUnlocked_RECIPES_settings_field_cb',
		'general',
		'ContentUnlocked_RECIPES_settings_section'
	);
}
 
add_action('admin_init', 'ContentUnlocked_RECIPES_settings_init');

// section content cb
function ContentUnlocked_RECIPES_settings_section_cb()
{    
}
 
// field content cb
function ContentUnlocked_RECIPES_settings_field_cb()
{
	// get the value of the setting we've registered with register_setting()
	$setting = get_option('ContentUnlocked_RECIPES_apikey');
	// output the field
	?>
	<input type="text" name="ContentUnlocked_RECIPES_apikey" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
	<?php
}
