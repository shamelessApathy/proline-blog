<?php

class ContentUnlockedRecipes extends WP_Widget 
{

	public function __construct() {

		$widget_ops = array( 
			'classname' => 'ContentUnlockedRecipes',
			'description' => 'ContentUnlocked Recipes',
		);
		parent::__construct( 'ContentUnlockedRecipeswidget', 'ContentUnlockedRecipes', $widget_ops );

	}

	public function form($instance)
	{
		extract($instance);

		$default = array( 
			'title' => __(''),
        	'code'=> __('')
			);


		$instance = wp_parse_args( (array)$instance, $default );			
		
		$myapikey = get_option( 'ContentUnlocked_RECIPES_apikey' );	        				
		$mychapter = $instance['code'];
		$mybookid = 102;
	
		echo '<p>';		        				
        $myurl = 'http://ebookcvm.contentoro.com/ebookc5/TOCWP6-inc.asp?bookid=' . $mybookid  .'&callbackurl=dummy&formid=' .  $this->get_field_id('code') . '&formname=' . $this->get_field_name('code') . '&formselected=' . $instance['code'] . '&customerid=' . $myapikey;
        $myreturnarray = wp_remote_get($myurl);
        echo $myreturnarray['body'];                
    echo '</p>';

	}

	public function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;        
		$instance['code'] = $new_instance['code'];
		return $instance;
	}

		
	public function widget($args, $instance) 
	{        
		extract($args, EXTR_SKIP);		
		extract($instance);

		echo $before_widget;

		$myapikey = get_option( 'ContentUnlocked_RECIPES_apikey' );
		$mychapter = $instance['code'];
		$mybookid = 102;
		
		echo '<div class="Contentoro_Recipes">';
		       
	        $myurl = 'http://ebookcvm.contentoro.com/ebookc5/ChapterWP6.asp?bookid=' . $mybookid . '&chapterid=' . $mychapter . '&customerid=' . $myapikey ;                
	        $myreturnarray = wp_remote_get($myurl);
        	echo $myreturnarray['body'];
                
		echo '</div>';	

		echo $after_widget;
	}

}