<?php
/*------------------------------------------------
Recent Posts Widget
------------------------------------------------*/
class wordchef_widget_recent_posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'wordchef wordchef_widget_recent_entries', 'description' => esc_html__( 'Your site&#8217;s most recent Posts with thumbnails.','wordchef') );
		parent::__construct('wordchef-recent-posts', esc_html__('WordChef Recent Posts','wordchef'), $widget_ops);
		$this->alt_option_name = 'wordchef_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'wordchef_widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts','wordchef' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5 ;
		if ( ! $number ) {
			$number = 5;
        }

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ( $r->have_posts() ) :
?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		} ?>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<div class="wordchef-recent-post clearfix">
                <span class="recent-post-thumb"><a href="<?php esc_url( the_permalink() ); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), array(75,75) ); ?></a></span>
                <div class="widget-post-meta">
                    <div class="recent-post-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php echo get_the_title(); ?></a></div>
                    <div class="widget-entry-meta">     
                        <span class="recent-post-date"><?php echo get_the_date('M j, Y'); ?></span>
                    </div><!-- .widget-entry-meta -->
                </div><!-- .widget-post-meta -->
            </div><!-- .wordchef-recent-post -->
		<?php endwhile; ?>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'wordchef_widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:','wordchef' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:','wordchef' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

<?php
	}
}

/*------------------------------------------------
Recent Comments Widget
------------------------------------------------*/
class wordchef_widget_recent_comments extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'wordchef wordchef_widget_recent_comments', 'description' => esc_html__( 'Your site&#8217;s most recent comments with thumbnails.','wordchef' ) );
		parent::__construct('wordchef-recent-comments', esc_html__('WordChef Recent Comments','wordchef'), $widget_ops);
		$this->alt_option_name = 'wordchef_widget_recent_comments';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array($this, 'recent_comments_style') );

		add_action( 'comment_post', array($this, 'flush_widget_cache') );
		add_action( 'edit_comment', array($this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array($this, 'flush_widget_cache') );
	}

	public function recent_comments_style() {

		/**
		 * Filter the Recent Comments default widget styles.
		 *
		 * @since 3.1.0
		 *
		 * @param bool   $active  Whether the widget is active. Default true.
		 * @param string $id_base The widget ID.
		 */
		if ( ! current_theme_supports( 'widgets' ) // Temp hack #14876
			|| ! apply_filters( 'show_recent_comments_widget_style', true, $this->id_base ) )
			return;
		?>
    <?php
	}

	public function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get('wordchef_widget_recent_comments', 'widget');
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
        
        ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Comments','wordchef' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		/**
		 * Filter the arguments for the Recent Comments widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Comment_Query::query() for information on accepted arguments.
		 *
		 * @param array $comment_args An array of arguments used to retrieve the recent comments.
		 */
		$comments = get_comments( apply_filters( 'widget_comments_args', array(
			'number'      => $number,
			'status'      => 'approve',
			'post_status' => 'publish'
		) ) );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		echo '<ul id="recentcomments">';
		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment) {
				echo '<li class="recentcomments">';
				/* translators: comments widget: 1: comment author, 2: post link */
				echo sprintf( '%1$s %2$s %3$s %4$s',
                    '<div class="clearfix"><div class="comment-author-avatar">'.get_avatar($comment, 75).'</div>',
                    '<div class="widget-post-meta">',
					'<div class="comment-author-link">' . get_comment_author_link() . '</div>',
                    '<div class="recent-comment-excerpt"><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . wp_trim_words( get_comment_excerpt(), 8 ) .'</a></div></div></div>'
				);
				echo '</li>';
			}
		}
		echo '</ul>';
		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'wordchef_widget_recent_comments', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['wordchef_widget_recent_comments']) )
			delete_option('wordchef_widget_recent_comments');

		return $instance;
	}
    
    public function flush_widget_cache() {
		wp_cache_delete('wordchef_widget_recent_comments', 'widget');
	}

	public function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:','wordchef' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of comments to show:','wordchef' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
<?php
	}
}

/*------------------------------------------------
Popular Posts Widget
------------------------------------------------*/
class wordchef_widget_popular_posts extends WP_Widget {
	function wordchef_widget_popular_posts() {
        
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wordchef worchef_widget_popular', 'description' => esc_html__( 'Displays most popular posts by view count','wordchef') );
        parent::__construct('popular-widget', esc_html__('WordChef Popular Posts','wordchef'), $widget_ops);
		$this->alt_option_name = 'wordchef_popular_posts';
	}
    
	function widget( $args, $instance ) {
		extract( $args );
		
        $title = ( !empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Popular Posts','wordchef' );
        $count = ( !empty( $instance['count'] ) ) ? $instance['count'] : 5 ;
        $days  = ( !empty( $instance['days'] ) ) ? $instance['days'] : 0 ;
        
        /** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        
        echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		if ( $days != 0 ) {
            $loop_args = array( 
                'ignore_sticky_posts' => true,
                'posts_per_page'      => (int) $count,
                'meta_key'            => 'post_views_count',
                'orderby'             => 'meta_value_num',
                'order'               => 'DESC',
                'suppress_filters'    => false,
                'date_query'          => array(
                    'after'           => date('Y-m-d', strtotime('-'.$instance['days'].' days'))
                )
            );	
        } else {
            $loop_args = array( 
                'ignore_sticky_posts' => true,
                'posts_per_page'      => (int) $count,
                'meta_key'            => 'post_views_count',
                'orderby'             => 'meta_value_num',
                'order'               => 'DESC',
                'suppress_filters'    => false
            );	
        }

        $loop = new WP_Query( $loop_args );
		
		if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post(); global $post; ?>

            <div class="popular-post clearfix">
                <span class="popular-post-thumb"><a href="<?php esc_url( the_permalink() ); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), array(75,75) ); ?></a></span>
                <div class="widget-post-meta">
                    <div class="popular-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php echo get_the_title(); ?></a></div>
                    <div class="widget-entry-meta">  
                        <div class="popular-date"><?php echo get_the_date('M j, Y'); ?></div>
                    </div><!-- .widget-entry-meta -->
                </div><!-- .widget-post-meta -->
            </div><!-- .popular-post -->
		
		<?php endwhile; endif; wp_reset_query();
		
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

        $instance['title'] = esc_attr( $new_instance['title'] );
		$instance['count'] = (int) $new_instance['count'];
        $instance['days']  = (int) $new_instance['days'];
		return $instance;
	}

	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'count' => 5, 'days' => 30 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:','wordchef'); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
 
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e('Number of posts:','wordchef'); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" size="3" value="<?php if ( !empty($instance['count']) ) { echo esc_attr( $instance['count'] ); } ?>" />
		</p>
		
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'days' ) ); ?>"><?php esc_html_e('Posted in the past X days:','wordchef'); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'days' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'days' ) ); ?>" size="3" value="<?php if ( !empty($instance['days']) ) { echo esc_attr( $instance['days'] ); } ?>" />
		</p>
		<p class="description"><?php esc_html_e('Use 0 for no time limit.','wordchef'); ?></p>
		<?php
	}

}

/*------------------------------------------------
About me Widget
------------------------------------------------*/
class wordchef_widget_about_me extends WP_Widget {
    function wordchef_widget_about_me() {
        
        /* Widget settings. */
		$widget_ops = array( 'classname' => 'wordchef wordchef-about-me', 'description' => esc_html__( 'An image and short blurb about yourself.','wordchef') );
        parent::__construct('wordchef_about_me', esc_html__('WordChef About Me','wordchef'), $widget_ops);
		$this->alt_option_name = 'wordchef_about_me';

        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
        add_action('admin_enqueue_styles', array($this, 'upload_styles'));
    }
    
    /* Javascripts for the media uploader */
    function upload_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('wordchef_upload_media_widget', get_template_directory_uri() . '/js/wordchef-upload-media.js', array( 'jquery' ),'1.0.0', true);
        wp_enqueue_media();
    }   
    /* Style for the media uploader */
    function upload_styles() {
        wp_enqueue_style('thickbox');
    }

    function widget( $args, $instance ) {
        
        $title = ( !empty($instance['title']) ? $instance['title'] : '' );
        $image = ( !empty($instance['image']) ? $instance['image'] : '' );
        $name  = ( !empty($instance['name']) ? $instance['name'] : '' );
        $text  = ( !empty($instance['text']) ? $instance['text'] : '' );
        
        echo $args['before_widget'];
        
		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
        if ( $image ) {
			echo '<div class="wordchef-about-me-image-container"><img src="'. esc_url( wp_get_attachment_url( $image ) ) .'" class="wordchef-about-me-image" alt="About me photo" /></div>';
		}
        if ( $name ) {
			echo '<div class="wordchef-about-me-name"><h6>'. esc_html( $name ) .'</h6></div>';
		}
        if ( $text ) {
			echo '<div class="wordchef-about-me-text"><p>'. esc_html( $text ) .'</p></div>';
		}
        
        echo $args['after_widget'];
    }
    
    function update( $new_instance, $old_instance ) {
        
        $instance = array();

        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? esc_attr( $new_instance['title'] ) : '';
        $instance['image'] = ( !empty( $new_instance['image'] ) ) ? esc_attr( $new_instance['image'] ) : '';
		$instance['name']  = ( !empty( $new_instance['name'] ) ) ? esc_html( $new_instance['name'] ) : '';
        $instance['text']  = ( !empty( $new_instance['text'] ) ) ? esc_html( $new_instance['text'] ) : '';
		return $instance;
    }

    function form( $instance ) {
        
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $image = isset( $instance['image'] ) ? $instance['image'] : '';
        $name  = isset( $instance['name'] ) ? $instance['name'] : '';
        $text  = isset( $instance['text'] ) ? $instance['text'] : '';
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:','wordchef' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>"><?php esc_html_e( 'Image:','wordchef' ); ?></label></br>
            <input name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" class="about_me_media_id widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" type="text" size="36"  value="<?php echo esc_attr( $image ); ?>"/>
            <input class="about_me_media_upload" type="button" value="<?php esc_html_e('Upload','wordchef'); ?>" />
            <input class="about_me_media_remove" type="button" value="<?php esc_html_e('Remove','wordchef'); ?>" />
            <p class="about_me_preview"><img src="<?php echo esc_url( wp_get_attachment_url( $image ) ); ?>" width="100%"></p>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>"><?php esc_html_e( 'Name:','wordchef' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php esc_html_e( 'Text:','wordchef' ); ?></label>
            <textarea rows="6" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_html( $text ); ?></textarea>
        </p>
    <?php
    }
    
}


/*------------------------------------------------
Image Widget
------------------------------------------------*/
class wordchef_widget_image extends WP_Widget {
    function wordchef_widget_image() {
     
     /* Widget settings. */
		$widget_ops = array( 'classname' => 'wordchef wordchef-image', 'description' => esc_html__( 'An image with optional link.','wordchef') );
        parent::__construct('wordchef_image', esc_html__('WordChef Image Banner','wordchef'), $widget_ops);
		$this->alt_option_name = 'wordchef_image';

        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
        add_action('admin_enqueue_styles', array($this, 'upload_styles'));
    }
    
    /* Javascripts for the media uploader */
    function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('wordchef_upload_media_widget', get_template_directory_uri() . '/js/wordchef-upload-media.js', array( 'jquery' ),'1.0.0', true);
        wp_enqueue_media();
    }   
    /* Style for the media uploader */
    function upload_styles()
    {
        wp_enqueue_style('thickbox');
    }

    function widget( $args, $instance )
    {
        $image = ( !empty($instance['image']) ? $instance['image'] : '' );
        $link  = ( !empty($instance['link']) ? $instance['link'] : '' );
        
        echo $args['before_widget'];
        
        if ( $image ) {
			echo '<a href="'. esc_url_raw( $link ) .'" target="_blank"><img src="'. esc_url( wp_get_attachment_url( $image ) ) .'" class="wordchef-image" alt="ad" /></a>';
		}
        
        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {

        $instance = array();

        $instance['image'] = ( !empty( $new_instance['image'] ) ) ? esc_url_raw( $new_instance['image'] ) : '';
        $instance['link'] = ( !empty( $new_instance['link'] ) ) ? esc_url_raw( $new_instance['link'] ) : '';
        
		return $instance;
    }

    function form( $instance ) {
        
        $image = isset( $instance['image'] ) ? $instance['image'] : '';
        $link  = isset( $instance['link'] ) ? $instance['link'] : '';
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>"><?php esc_html_e( 'Image:','wordchef' ); ?></label></br>
            <input name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" class="widefat image_media_id" type="text" size="36"  value="<?php echo esc_attr( $image ); ?>" />
            <input class="image_media_upload" type="button" value="<?php esc_html_e('Upload','wordchef'); ?>" />
            <input class="image_media_remove" type="button" value="<?php esc_html_e('Remove','wordchef'); ?>" />
            <p class="image_preview"><img src="<?php echo esc_url( wp_get_attachment_url($image) ); ?>" width="100%"></p>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>"><?php esc_html_e( 'Link:','wordchef' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />
        </p>

    <?php
    }
}


/*------------------------------------------------
Social Widget
------------------------------------------------*/
class wordchef_widget_social extends WP_Widget {
    function wordchef_widget_social() {
        
        /* Widget settings. */
		$widget_ops = array( 'classname' => 'wordchef wordchef-social', 'description' => esc_html__( 'Social media icon links.','wordchef') );
        parent::__construct('wordchef_social', esc_html__('WordChef Social Media','wordchef'), $widget_ops);
		$this->alt_option_name = 'wordchef_social';
    }

    public function widget( $args, $instance )
    {
        $title            = ( ! empty( $instance['title'] )) ? $instance['title'] : '';
        $facebook         = ( ! empty( $instance['facebook'] )) ? $instance['facebook'] : '';
        $twitter          = ( ! empty( $instance['twitter'] )) ? $instance['twitter'] : '';
        $pinterest        = ( ! empty( $instance['pinterest'] )) ? $instance['pinterest'] : '';
        $instagram        = ( ! empty( $instance['instagram'] )) ? $instance['instagram'] : '';
        $tumblr           = ( ! empty( $instance['tumblr'] )) ? $instance['tumblr'] : '';
        $googleplus       = ( ! empty( $instance['googleplus'] )) ? $instance['googleplus'] : '';
        $linkedin         = ( ! empty( $instance['linkedin'] )) ? $instance['linkedin'] : '';
        $youtube          = ( ! empty( $instance['youtube'] )) ? $instance['youtube'] : '';
        $vimeo            = ( ! empty( $instance['vimeo'] )) ? $instance['vimeo'] : '';
        $rss              = ( ! empty( $instance['rss'] )) ? $instance['rss'] : '';
   
        echo $args['before_widget'];
        
        if ( $title ) {
            /** This filter is documented in wp-includes/default-widgets.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

        echo '<div class="wordchef-social-widget-links-center">';

        if ( $facebook ) {
			echo '<a href="'. esc_url( $facebook ) .'" class="social-widget-facebook" target="_blank"><i class="fa fa-facebook"></i></a>';
		}
        if ( $twitter ) {
			echo '<a href="'. esc_url( $twitter ) .'" class="social-widget-twitter" target="_blank"><i class="fa fa-twitter"></i></a>';
		}
        if ( $pinterest ) {
			echo '<a href="'. esc_url( $pinterest ) .'" class="social-widget-pinterest" target="_blank"><i class="fa fa-pinterest"></i></a>';
		}
        if ( $instagram ) {
			echo '<a href="'. esc_url( $instagram ) .'" class="social-widget-instagram" target="_blank"><i class="fa fa-instagram"></i></a>';
		}
        if ( $tumblr ) {
			echo '<a href="'. esc_url( $tumblr ) .'" class="social-widget-tumblr" target="_blank"><i class="fa fa-tumblr"></i></a>';
		}
        if ( $googleplus ) {
			echo '<a href="'. esc_url( $googleplus ) .'" class="social-widget-googleplus" target="_blank"><i class="fa fa-google-plus"></i></a>';
		}
        if ( $linkedin ) {
			echo '<a href="'. esc_url( $linkedin ) .'" class="social-widget-linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>';
		}
        if ( $youtube ) {
			echo '<a href="'. esc_url( $youtube ) .'" class="social-widget-youtube" target="_blank"><i class="fa fa-youtube"></i></a>';
		}
        if ( $vimeo ) {
			echo '<a href="'. esc_url( $vimeo ) .'" class="social-widget-vimeo" target="_blank"><i class="fa fa-vimeo-square"></i></a>';
		}
        if ( $rss ) {
			echo '<a href="'. esc_url( $rss ) .'" class="social-widget-rss" target="_blank"><i class="fa fa-rss"></i></a>';
		}
        echo '</div>';
        
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title']            = ( !empty( $new_instance['title'] ) ) ? esc_attr( $new_instance['title'] ) : '';
        $instance['facebook']         = ( !empty( $new_instance['facebook'] ) ) ? esc_url( $new_instance['facebook'] ) : '';
        $instance['twitter']          = ( !empty( $new_instance['twitter'] ) ) ? esc_url( $new_instance['twitter'] ) : '';
        $instance['pinterest']        = ( !empty( $new_instance['pinterest'] ) ) ? esc_url( $new_instance['pinterest'] ) : '';
        $instance['instagram']        = ( !empty( $new_instance['instagram'] ) ) ? esc_url( $new_instance['instagram'] ) : '';
        $instance['tumblr']           = ( !empty( $new_instance['tumblr'] ) ) ? esc_url( $new_instance['tumblr'] ) : '';
        $instance['googleplus']       = ( !empty( $new_instance['googleplus'] ) ) ? esc_url( $new_instance['googleplus'] ) : '';
        $instance['linkedin']         = ( !empty( $new_instance['linkedin'] ) ) ? esc_url( $new_instance['linkedin'] ) : '';
        $instance['youtube']          = ( !empty( $new_instance['youtube'] ) ) ? esc_url( $new_instance['youtube'] ) : '';
        $instance['vimeo']            = ( !empty( $new_instance['vimeo'] ) ) ? esc_url( $new_instance['vimeo'] ) : '';
        $instance['rss']              = ( !empty( $new_instance['rss'] ) ) ? esc_url( $new_instance['rss'] ) : '';
        
		return $instance;
    }
    
    public function form( $instance ) {
        
        $title                  = isset( $instance['title'] ) ? $instance['title'] : '';
        $facebook               = isset( $instance['facebook'] ) ? $instance['facebook'] : '';
        $twitter                = isset( $instance['twitter'] ) ? $instance['twitter'] : '';
        $pinterest              = isset( $instance['pinterest'] ) ? $instance['pinterest'] : '';
        $instagram              = isset( $instance['instagram'] ) ? $instance['instagram'] : '';
        $tumblr                 = isset( $instance['tumblr'] ) ? $instance['tumblr'] : '';
        $googleplus             = isset( $instance['googleplus'] ) ? $instance['googleplus'] : '';
        $linkedin               = isset( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $youtube                = isset( $instance['youtube'] ) ? $instance['youtube'] : '';
        $vimeo                  = isset( $instance['vimeo'] ) ? $instance['vimeo'] : '';
        $rss                    = isset( $instance['rss'] ) ? $instance['rss'] : '';
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:','wordchef' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <!-- Facebook -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>"><?php esc_html_e( 'Facebook:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $facebook ); ?>" />
        </p>
        <!-- Twitter -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>"><?php esc_html_e( 'Twitter:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $twitter ); ?>" />
        </p>
        <!-- Pinterest -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>"><?php esc_html_e( 'Pinterest:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $pinterest ); ?>" />
        </p>
        <!-- Instagram -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>"><?php esc_html_e( 'Instagram:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $instagram ); ?>" />
        </p>
        <!-- Tumblr -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'tumblr' ) ); ?>"><?php esc_html_e( 'Tumblr:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'tumblr' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $tumblr ); ?>" />
        </p>
        <!-- GooglePlus -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'googleplus' ) ); ?>"><?php esc_html_e( 'Google+:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'googleplus' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'googleplus' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $googleplus ); ?>" />
        </p>
        <!-- LinkedIn -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>"><?php esc_html_e( 'LinkedIn:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $linkedin ); ?>" />
        </p>
        <!-- YouTube -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>"><?php esc_html_e( 'YouTube:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $youtube ); ?>" />
        </p>
        <!-- Vimeo -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'vimeo' ) ); ?>"><?php esc_html_e( 'Vimeo:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'vimeo' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'vimeo' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $vimeo ); ?>" />
        </p>
        <!-- RSS -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>"><?php esc_html_e( 'RSS:','wordchef' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $rss ); ?>" />
        </p>

    <?php
    }
}

/*---------------------
Facebook Like Box
---------------------*/
class wordchef_widget_facebook extends WP_Widget {

	function __construct() {
		parent::__construct(
			'wordchef_widget_facebook', // Base ID
			esc_html__( 'WordChef Facebook Like Box', 'wordchef' ), // Name
			array( 'description' => esc_html__( 'A Facebook Like Box', 'wordchef' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
                
        $page_name    = ( !empty($instance['page_name']) ? $instance['page_name'] : '' );
        $show_faces   = ( !empty($instance['show_faces']) ? $instance['show_faces'] : '' );
        $show_posts   = ( !empty($instance['show_posts']) ? $instance['show_posts'] : '' );
        $small_header = ( !empty($instance['small_header']) ? $instance['small_header'] : '' );
        $hide_cover   = ( !empty($instance['hide_cover']) ? $instance['hide_cover'] : '' );
        $language     = ( !empty($instance['language']) ? $instance['language'] : 'en_US' );
        
        // Facebook widget JS ?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/<?php echo esc_attr( $language ); ?>/all.js#xfbml=1&version=v2.4";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        
        <div class="wordchef-facebook-container">
            <div class="fb-page"
                data-href="https://www.facebook.com/<?php echo esc_html( $page_name ); ?>"
                data-show-facepile="<?php echo ( $show_faces == 'true' ) ? 'true' : 'false'; ?>"
                data-show-posts="<?php echo ( $show_posts == 'true' ) ? 'true' : 'false'; ?>"
                data-small-header="<?php echo ( $small_header == 'true' ) ? 'true' : 'false'; ?>"
                data-hide-cover="<?php echo ( $hide_cover == 'true' ) ? 'true' : 'false'; ?>"
                data-width="500">
            </div>
        </div>
        <?php
        
		echo $args['after_widget'];
	}

	public function form( $instance ) {
                
        $title        = isset( $instance['title'] ) ? $instance['title'] : '';
        $page_name    = isset( $instance['page_name'] ) ? $instance['page_name'] : '';
        $show_faces   = isset( $instance['show_faces'] ) ? $instance['show_faces'] : '';
        $show_posts   = isset( $instance['show_posts'] ) ? $instance['show_posts'] : '';
        $small_header = isset( $instance['small_header'] ) ? $instance['small_header'] : '';
        $hide_cover   = isset( $instance['hide_cover'] ) ? $instance['hide_cover'] : '';
        $language     = isset( $instance['language'] ) ? $instance['language'] : '';
        ?>

        <!-- Widget Title: Text Input -->
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'wordchef') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" /></p>

        <!-- Page name: Text Input -->
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'page_name' ) ); ?>"><?php esc_html_e('Page Name: http://www.facebook.com/[page_name]', 'wordchef') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_name' ) ); ?>" value="<?php echo esc_attr( $page_name ); ?>" /></p>

        <!-- Show Faces: Checkbox -->
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>"><?php esc_html_e('Show Faces', 'wordchef') ?></label>
        <input type="checkbox" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_faces' ) ); ?>" value="true" <?php echo ( $show_faces == "true" ? "checked='checked'" : ""); ?> /></p>

        <!-- Show Stream: Checkbox -->
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>"><?php esc_html_e('Show Posts', 'wordchef') ?></label><input type="checkbox" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_posts' ) ); ?>" value="true" <?php echo ( $show_posts == "true" ? "checked='checked'" : ""); ?> /></p>

        <!-- Show Header: Checkbox -->
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>"><?php esc_html_e('Small Header', 'wordchef') ?></label>
        <input type="checkbox" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_header' ) ); ?>" value="true" <?php echo ( $small_header == "true" ? "checked='checked'" : ""); ?> /></p>

        <!-- Hide Cover: Checkbox -->
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php esc_html_e('Hide Cover Photo', 'wordchef') ?></label>
        <input type="checkbox" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" value="true" <?php echo ( $hide_cover == "true" ? "checked='checked'" : ""); ?> /></p>

        <!-- Page name: Text Input -->
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'language' ) ); ?>"><?php esc_html_e('Facebook Locale (for translations):', 'wordchef') ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'language' ) ); ?>" value="<?php echo esc_attr( $language ); ?>" /></p>

    <?php
	}

	public function update( $new_instance, $old_instance ) {

        $instance                 = array();
        $instance['title']        = ( ! empty( $new_instance['title'] ) ) ? esc_attr( $new_instance['title'] ) : '';
        $instance['page_name']    = ( ! empty( $new_instance['page_name'] ) ) ? esc_attr( $new_instance['page_name'] ) : '';
        $instance['show_faces']   = ( ! empty( $new_instance['show_faces'] ) ) ? esc_attr( $new_instance['show_faces'] ) : '';
        $instance['show_posts']   = ( ! empty( $new_instance['show_posts'] ) ) ? esc_attr( $new_instance['show_posts'] ) : '';
        $instance['small_header'] = ( ! empty( $new_instance['small_header'] ) ) ? esc_attr( $new_instance['small_header'] ) : '';
        $instance['hide_cover']   = ( ! empty( $new_instance['hide_cover'] ) ) ? esc_attr( $new_instance['hide_cover'] ) : '';
        $instance['language']     = ( ! empty( $new_instance['language'] ) ) ? esc_attr( $new_instance['language'] ) : '';
 
        return $instance;
	}

} // class wordchef_widget_facebook

//Registed wordchef recent posts widget
function wordchef_register_custom_widgets() {
    register_widget( 'wordchef_widget_recent_posts' );
    register_widget( 'wordchef_widget_recent_comments' );
    register_widget( 'wordchef_widget_popular_posts' );
    register_widget( 'wordchef_widget_about_me' );
    register_widget( 'wordchef_widget_image' );
    register_widget( 'wordchef_widget_social' );
    register_widget( 'wordchef_widget_facebook' );
}
add_action( 'widgets_init', 'wordchef_register_custom_widgets' );