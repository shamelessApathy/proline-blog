<?php
/*
Plugin Name: Custom facebook widget pro
Description: Display facebook page feed on your WordPress site by using this plugin. Simply add your page url and page id in widget setting. 
Version: 2.3.2
Author: Techvers
Author URI: http://techvers.com/
License: GPLv2 or later
Text Domain: CFWP
*/

//define( 'CFWP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );




define("c9test", "CFWP1");

/**
 * Get Ready Plugin Translation
 */
add_action('plugins_loaded', 'FacebookTranslation');
function FacebookTranslation() {
	load_plugin_textdomain( c9test, FALSE, dirname( plugin_basename(__FILE__)).'/languages/' );
}

		// Define plugin url 
	define( 'CFWP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'CFWP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	
	// Include requred file 
	//require_once(CFWP_PLUGIN_DIR.'/shortcode.php');
	//require_once(CFWP_PLUGIN_DIR.'/default_settings.php');

	// Register Required css and js 
	add_action( 'admin_init', 'CFWP_plugin_scripts' );
	function CFWP_plugin_scripts(){
								if( is_admin() ){
								wp_register_script('CFWP-facebook-admin-easytab',CFWP_PLUGIN_URL.'lib/js/admin-js/jquery.easytabs.min.js');
								wp_register_script('CFWP-facebook-admin-custom-js',CFWP_PLUGIN_URL.'lib/js/admin-js/admin-custom-js.js');
								wp_register_script('CFWP-facebook-admin-wp-color-js',CFWP_PLUGIN_URL.'lib/js/admin-js/admin-wp-color-picker.js');
								wp_register_script( 'custom-script-handle', plugins_url(  'lib/js/admin-js/tech-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
								wp_register_style('admin_style',CFWP_PLUGIN_URL.'lib/style/admin-panel-style.css');
								// Add the color picker css file       
								wp_enqueue_style( 'wp-color-picker' );  
								// Include our custom jQuery file with WordPress Color Picker dependency
								 
								}
	}


// Menu function hook
//$Menu_status = get_option('CFWP_hide_pro_panel'); 
//if($Menu_status == 'on'){
	add_action('admin_menu', 'custom_facebook_menu');
//}
	//Menu creation function
	function custom_facebook_menu(){

									$CFWP_facebook_hook_suffix =  add_menu_page(__('Techvers Facebook','CFWP'), __('Techvers Facebook','CFWP'), 'manage_options', 'custom-facebook', 'tech_facebook_output' );

									add_action('admin_print_scripts-' . $CFWP_facebook_hook_suffix, 'tech_facebook_admin_scripts');
		
		}

	// Enque required css and js	
	function tech_facebook_admin_scripts() {
			/* Link our already registered script to a page */
			wp_enqueue_script( 'CFWP-facebook-admin-easytab' );
			wp_enqueue_script( 'CFWP-facebook-admin-custom-js' );
			wp_enqueue_script('CFWP-facebook-admin-wp-color-js');
			wp_enqueue_script( 'custom-script-handle' );
			wp_enqueue_style( 'wp-color-picker' ); 
			wp_enqueue_style( 'admin_style' ); 
		}
// Create option panel		
	function tech_facebook_output(){
	?>
		<body>
			<h2>Techvers facebook Premium Settings. <span ><a style="color: red;"target="_blank" href="http://techvers.com/facebook-like-box/" 14px;"=""><span>Buy our pro plugin just in 2$</a> </span></h2>
			
			
			<div id="tab-container" class='tab-container'>
				<ul class='etabs'>
				   <li class='tab'><a href="#tabs1-Gsettings">Facebook shortcode settings </a></li>
				   <li class='tab'><a href="#tabs1-sticky-fb-box">Facebook sticky box settings</a></li>
				   <li class='tab'><a href="#tabs1-Design">Custom css and js </a></li>
					<li class='tab'><a href="#tab1-show-love">Show some love</a></li>
				</ul>
				<div class='panel-container'>
					<div id="tabs1-Gsettings">
						
						<form  name="CFWP_form" method="post">
							<h2>Settings</h2>
							<table class="form-table">
							
								<tr valign="top">
									<th scope="row"><label><?php _e('Facebook Page id:','CFWP');?> </label></th>
									<td><input type="text" id="CFWP_page_id" disabled="true" name="CFWP_page_id" value="" /><span>&nbsp &nbsp <a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span></td>
								</tr>
			 
								<tr valign="top">
									<th scope="row"><label><?php _e('Show posts from the Page timeline:','CFWP');?> </label></th>
									<td>
										<select name="CFWP_show_posts_page_timeline" disabled="true" style="width:70px;">
											<option value="yes"><?php _e('Yes'); ?></option>
											<option value="no" ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Height:','CFWP')?> </label></th>
									<td>
										<input type="text" id="CFWP_height" disabled="true"  name="CFWP_height" value="600" size="5" /><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
			  
									</td>
									
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Width:','CFWP');?> </label></th>
									<td>
										<input type="text" id="CFWP_width"disabled="true" name="CFWP_width" value="500" size="5" /><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
			
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Theme Border:','CFWP');?> </label></th>
									<td>
										<select name="CFWP_theme_boder" style="width:70px;"disabled="true">
											<option value="0"  >0</option>
											<option value="1" >1</option>
											<option value="2"  >2</option>
											<option value="3" >3</option>
											<option value="4" >4</option>
											<option value="5" >5</option>
											<option value="6" >6</option>
										</select> px<span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
								<tr valign="top">
										<th scope="row"><label> <?php _e('Theme border color:','CFWP');?></label></th>
									<td>
										<input type="text" id="CFWP_theme_border_color" disabled="true" class="color-field"  name="CFWP_theme_border_color" value="" size="5" /><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label><?php _e('Hide Cover:','CFWP');?></label></th>
									<td>
										<select name="CFWP_Hide_cover" style="width:70px;" disabled="true">
											<option value="yes"  ><?php _e('Yes'); ?></option>
											<option value="no"  ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Show Friends profile Pic:','CFWP');?></label></th>
									<td>
										<select name="CFWP_show_frnd_pic" style="width:70px;" disabled="true">
											<option value="yes" ><?php _e('Yes'); ?></option>
											<option value="no"  ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Show Small Header:','CFWP');?> </label></th>
									<td>
										<select name="CFWP_small_header"style="width:70px;" disabled="true">
											<option value="yes"  ><?php _e('Yes'); ?></option>
											<option value="no" ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Like box language:','CFWP');?> </label></th>
									<td>
										<input type="text" disabled="true" id="CFWP_theme_like_box_lang"  name="CFWP_theme_like_box_lang" value=""/>(en_US,de_DE...)<span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
		   
							</table>
							<input type="submit" name="FGsettings" value="Save Changes" class="button button-primary"/>
						</form> 



					</div>
					<div id="tabs1-Design">
	   
						

						<form  name="CustomCssAndJs" method="post">

							<table class="form-table">
								<tbody>
									<tr valign="top">
										<td style="padding-bottom: 0;">
											<strong style="font-size: 15px;">Custom CSS</strong><br><strong style="font-size: 12px;">
										</td>
									</tr>
									
									<tr valign="top">
										<td>
											<textarea name="CFWP_facebook_custom_css" id="CFWP_facebook_custom_css"  disabled="true" style="width: 70%;" rows="7"></textarea><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
										</td>
									</tr>
									
									<tr valign="top">
										<td style="padding-bottom: 0;">
											<strong style="font-size: 15px;">Custom JavaScript</strong><br><strong style="font-size: 12px;"></td>
										</tr>
										<tr valign="top">
											<td>
												<textarea name="CFWP_facebook_custom_js" id="CFWP_facebook_custom_js"  style="width: 70%;" disabled="true" rows="7"></textarea><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
											</td>
										</tr>
								</tbody>
							</table>
							<input type="submit" name="CustomCssAndJs" value="Save Changes" class="button button-primary"/>
						</form> 
					</div>
	  
					<div id="tabs1-sticky-fb-box">
						
						<form  name="CFWP_form" method="post">
							<h2>Settings</h2>
							<table class="form-table">
							
								<tr valign="top">
									<th scope="row"><label><?php _e('Facebook sticky enable:','CFWP');?> </label></th>
										<td>
											<select name="CFWP_sticky_enable_setting" disabled="true" style="width:70px;">
												<option value="yes"  ><?php _e('Yes'); ?></option>
												<option value="no" ><?php _e('No'); ?></option>
											</select><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
										</td>
								</tr>
								
								<tr valign="top">
									<th scope="row"><label><?php _e('Facebook Page id:','CFWP');?> </label></th>
									<td><input type="text" id="CFWP_page_id"  name="CFWP_page_id" disabled="true" value="" /><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span></td>
								</tr>
			 
								<tr valign="top">
									<th scope="row"><label><?php _e('Show posts from the Page timeline:','CFWP');?> </label></th>
									<td>
										<select name="CFWP_show_posts_page_timeline" style="width:70px;" disabled="true">
											<option value="yes"  ><?php _e('Yes'); ?></option>
											<option value="no"  ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
			
								<tr valign="top">
									<th scope="row"><label> <?php _e('Height:','CFWP')?> </label></th>
									<td>
									<input type="text" id="CFWP_height"  name="CFWP_height" disabled="true" value="600" size="5" /><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
		
								<tr valign="top">
									<th scope="row"><label> <?php _e('Width:','CFWP');?> </label></th>
									<td>
										<input type="text" id="CFWP_width"  name="CFWP_width" disabled="true" value="500" size="5" /><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
		
								<tr valign="top">
									<th scope="row"><label> <?php _e('Theme Border:','CFWP');?> </label></th>
									<td>
										<select name="CFWP_theme_boder" style="width:70px;" disabled="true">
											<option value="0" >0</option>
											<option value="1" >1</option>
											<option value="2" >2</option>
											<option value="3" >3</option>
											<option value="4" >4</option>
											<option value="5" >5</option>
											<option value="6" >6</option>
										</select> px<span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label> <?php _e('Theme border color:','CFWP');?></label></th>
									<td>
										<input type="text" id="CFWP_theme_border_color"disabled="true" class="color-field"  name="CFWP_theme_border_color" value="" size="5" /><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
									</td>
								</tr>
								<!--
								<tr valign="top">
								<th scope="row"><label><?php// _e('Hide Cover:','CFWP');?></label></th>
								<td>
									<select name="CFWP_Hide_cover" style="width:70px;">
											<option value="yes" <?php //if($CFWP_settings['CFWP_Hide_cover'] == "yes") echo 'selected="selected"' ?> ><?php// _e('Yes'); ?></option>
											<option value="no" <?php //if($CFWP_settings['CFWP_Hide_cover'] == "no") echo 'selected="selected"' ?> ><?php //_e('No'); ?></option>
										</select>
								</td>
								</tr>-->
				
								<tr valign="top">
								<th scope="row"><label> <?php _e('Show Friends profile Pic:','CFWP');?></label></th>
								<td>
									<select name="CFWP_show_frnd_pic" disabled="true" style="width:70px;">
											<option value="yes"  ><?php _e('Yes'); ?></option>
											<option value="no"  ><?php _e('No'); ?></option>
										</select><span>&nbsp &nbsp<a target="_blank" href="http://techvers.com/facebook-like-box/">Upgrade to pro</a></span>
								</td>
								</tr>
								<!--
								<tr valign="top">
								<th scope="row"><label> <?php //_e('Show Small Header:','CFWP');?> </label></th>
								<td>
									<select name="CFWP_small_header"style="width:70px;">
											<option value="yes" <?php //if($CFWP_settings['CFWP_small_header'] == "yes") echo 'selected="selected"' ?> ><?php //_e('Yes'); ?></option>
											<option value="no" <?php //if($CFWP_settings['CFWP_small_header'] == "no") echo 'selected="selected"' ?> ><?php //_e('No'); ?></option>
									</select>
								</td>
								</tr>-->
		   
							</table>
							<input type="submit" name="FSsettings" value="Save Changes" class="button button-primary"/>
						</form> 
					</div>
					
					<div id="tab1-show-love">
					
					<p>Support us by show some love. </p>
					<a class="buy-button buy" target="_blank" href="http://techvers.com/facebook-like-box/" 14px;"=""><span>$ 2</span>Buy It</a>
					<a class="buy-button rate" target="_blank" href="https://wordpress.org/support/view/plugin-reviews/custom-facebook-widget-pro"><span>* </span>Rate It</a>
					<a class="buy-button buy-package" target="_blank" href="http://techvers.com/" 14px;"=""><span>$10</span>Buy All plugin just in $8</a>
					</div>
	 
				</div>
			</div>

		</body>
		<?php
		}

class CFWP_Facebook_widget extends WP_Widget{
	
		function __construct() {
			parent::__construct(
				'CFWP_facebook', 
				'Custom facebook widget pro',
				array( 'description' => __( 'Display latest feed from your Facebook page', 'CFWP' ), ) 
			);
		}
	/**
		* Front-end display of widget.
	 */
		public function widget( $args, $instance ) {
			$defaults = $this->CFWP_defaults_settings();
			$instance = wp_parse_args( (array) $instance, $defaults );
			extract($args);
			$CFWP_title = apply_filters('CFWP_title', $instance['CFWP_title']);		
			echo $before_widget;
			if (!empty($CFWP_title)) {	echo $before_title . $CFWP_title . $after_title;	}
			$CFWP_facebook_page_url    = "https://www.facebook.com/".$instance['CFWP_facebook_page_url'];
			$CFWP_widget_height             =   $instance['CFWP_widget_height'];
			$CFWP_widget_width              =   $instance['CFWP_widget_width'];
			$CFWP_widget_show_post          =   ($instance['CFWP_widget_show_post'] =='yes')? 'true':'false';
			$CFWP_widget_data_hide_cover     =   ($instance['CFWP_widget_data_hide_cover'] == 'yes')? 'true': 'false';
			$CFWP_widget_show_frnddp    =   	($instance['CFWP_widget_show_frnddp'] == 'yes')? 'true':'false';
			$CFWP_widget_small_header   =       ($instance['CFWP_widget_small_header'] == 'yes')? 'true':'false';
			?>
			<script>
			(function (doc) {
				var js;
				var id = 'facebook-jssdk';
				var ref = doc.getElementsByTagName('script')[0];
						if (doc.getElementById(id)) {return;}
							js = doc.createElement('script');
							js.id = id;
							js.async = true;
							js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
							ref.parentNode.insertBefore(js, ref);
						}(document));
			</script>
			
			<div id="fb-root"></div>
				<div class="fb-page" data-href="<?php echo $CFWP_facebook_page_url;?>" data-width="<?php echo $CFWP_widget_width;?>" data-height="<?php echo $CFWP_widget_height;?>" data-show-posts="<?php echo $CFWP_widget_show_post; ?>" data-small-header="<?php echo $CFWP_widget_small_header; ?>" data-adapt-container-width=""  data-hide-cover="<?php echo $CFWP_widget_data_hide_cover;?>" data-show-facepile="<?php echo $CFWP_widget_show_frnddp;?>" ></div>
				  
			<?php
			echo $after_widget;
		}
	/**
		* Back-end widget form.
    */
		public function form( $instance ) {
			
		
		$defaults = $this->CFWP_defaults_settings();

			/** Merge the user-selected arguments with the defaults. */
			$instance = wp_parse_args( (array) $instance, $defaults );
		
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'CFWP_title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'CFWP_title' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_title' ); ?>" type="text" value="<?php echo esc_attr( $instance['CFWP_title'] ); ?>">
			</p>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'CFWP_facebook_page_url' ); ?>"><?php _e( 'Facebook Page Id:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'CFWP_facebook_page_url' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_facebook_page_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['CFWP_facebook_page_url']); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'CFWP_widget_height' ); ?>"><?php _e( 'Height:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'CFWP_widget_height' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_widget_height' ); ?>" type="text" value="<?php echo esc_attr( $instance['CFWP_widget_height'] ); ?>">
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'CFWP_widget_width' ); ?>"><?php _e( 'Width:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'CFWP_widget_width' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_widget_width' ); ?>" type="text" value="<?php echo esc_attr( $instance['CFWP_widget_width'] ); ?>">
			</p>
			
			
			<p>
				<label for="<?php echo $this->get_field_id( 'CFWP_widget_show_post' ); ?>"><?php _e( 'Show posts from the Page timeline:' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'CFWP_widget_show_post' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_widget_show_post' ); ?>">
					<option value="yes" <?php if($instance['CFWP_widget_show_post'] == "yes") echo "selected=selected" ?>>Yes</option>
					<option value="no" <?php if($instance['CFWP_widget_show_post'] == "no") echo "selected=selected" ?>>No</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'CFWP_widget_data_hide_cover' ); ?>"><?php _e( 'Hide Cover:' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'CFWP_widget_data_hide_cover' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_widget_data_hide_cover' ); ?>">
					<option value="yes" <?php if($instance['CFWP_widget_data_hide_cover'] == "yes") echo "selected=selected" ?>>Yes</option>
					<option value="no" <?php if($instance['CFWP_widget_data_hide_cover'] == "no") echo "selected=selected" ?>>No</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'CFWP_widget_show_frnddp' ); ?>"><?php _e( 'Show Liked Friends profile Pic:' ); ?><span style="color:red;">Available in pro</span></label>
				<select disabled="" class="widefat" id="" name="">
					<option value="yes" >Yes</option>
					<option value="no" >No</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'CFWP_widget_small_header' ); ?>"><?php _e( 'Show Small Header' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'CFWP_widget_small_header' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_widget_small_header' ); ?>">
					<option value="yes" <?php if($instance['CFWP_widget_small_header'] == "yes") echo "selected=selected" ?>>Yes</option>
					<option value="no" <?php if($instance['CFWP_widget_small_header'] == "no") echo "selected=selected" ?>>No</option>
				</select>
			</p>
			
			<!--<p>
			
					<label for ="<?php echo $this-> get_field_id('CFWP_widget_hide_pro_panel');?>"><?php _e('Hide custom facebok pro setting panel:');?></label><input type="checkbox" id="<?php echo $this->get_field_id( 'CFWP_widget_hide_pro_panel' ); ?>" name="<?php echo $this->get_field_name( 'CFWP_widget_hide_pro_panel' ); ?> "<?php if($instance['CFWP_widget_hide_pro_panel']== 'on'){echo checked;} ?>>
			</p>-->

			<p>
			<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/custom-facebook-widget-pro"><img src="<?php echo CFWP_PLUGIN_URL.'image/star.png' ;?>" /> </a>
			<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/custom-facebook-widget-pro">Rate us </a>
				<span style="float:right;">
				<!--<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/custom-facebook-widget-pro"><img src="<?php echo CFWP_PLUGIN_URL.'image/update.GIF' ;?>" /> </a>-->
			<a target="_blank" href="http://techvers.com/">Upgrade to pro</a>
			
				</span>
			</p>
			
			<p>
			</p>

			<?php
		}
	
	/**
		*Updating widget replacing old instances with new.
	**/
		 public function update( $new_instance, $old_instance ) {
			/** Default Args */
			$defaults = $this->CFWP_defaults_settings();
			$instance = $old_instance;
			foreach( $defaults as $key => $val ) {
				$instance[$key] = strip_tags( $new_instance[$key] );
			}
			update_option('CFWP_hide_pro_panel',$instance['CFWP_widget_hide_pro_panel']);
			return $instance;
		}
	
	/** 
		*Set up the default form values. 
	*/
		function CFWP_defaults_settings() {
			$defaults = array(
				'CFWP_title' => esc_attr__( 'Custom Facebook Widget Pro', 'CFWP'),
				'CFWP_facebook_page_url' => 'natgeo',
				'CFWP_widget_height' => 400,
				'CFWP_widget_width' => 300,
				'CFWP_widget_show_post' => 'yes',
				'CFWP_widget_data_hide_cover' => 'no',
				'CFWP_widget_show_frnddp' => 'yes',
				'CFWP_widget_small_header' => 'yes',
				'CFWP_widget_hide_pro_panel' => 'on'
			);
			return $defaults;
		}
}
	/**
	*register CFWP_Facebook_widget widget
	**/
		function RegisterFacebookWidget() {
			register_widget( 'CFWP_Facebook_widget' );
		}
		add_action( 'widgets_init', 'RegisterFacebookWidget' );
?>
