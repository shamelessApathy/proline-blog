<?php
/**
 * Ebook download widget class
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 class Ebook_Download_Widget extends WP_Widget { 

    public function __construct() {
        $widget_ops = array( 'classname' => 'widget_recent_entries', 'description' => 'Your site’s ebooks.' );
        parent::__construct( 'widget-ebook-download', 'Ebook Download', $widget_ops );
        $this->alt_option_name = 'widget_ebook_download';

        add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
    }

    public function widget( $args, $instance ) {
        global $post;
        
        $cache = array();

        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'widget_ebook_download', 'widget' );
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

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '', 'ebook-download' ) : $instance['title'], $instance, $this->id_base );
        $posttype = $instance['posttype'];
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
            $number = 1;
        }

        $post_types = get_post_types( array( 'public' => true ), 'objects' );

        if ( array_key_exists( $posttype, (array) $post_types ) ) {
            $r = new WP_Query( array(
                'post_type' => 'ebookdownload',
                'posts_per_page' => $number,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
            ) );

            if ( $r->have_posts() ) : ?>
                <?php echo $args['before_widget']; ?>
                <div class="ebookstitle">
        <?php if ( $title ) {
                    echo $args['before_title'] . $title . $args['after_title'];
                } ?></div>
                 <div class="ebooks">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
        
        <?php 
            $ebookdownloadurl = get_post_meta(get_the_ID(), 'ebookdownloadurl', true);
            $ebookdownloadid = get_the_ID();
            if (get_post_thumbnail_id( $post->ID )){
        ?>
<div class="ebook"><img src="<?php echo $ebookimage = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );?>" target="_blank" alt="<?php echo the_title(); ?>">
<?php } ?>               
<?php 
if(isset($_POST['ebookdownloadform'])) {
if (empty($_POST["downloademail"])) {
 $ebookdownload_lang_emailrequired = get_option( 'ebookdownload_lang_emailrequired' );
 echo "<center><strong>$ebookdownload_lang_emailrequired</strong></center>";?>
 <form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>" class="ebookdownloadform">
                    </div>
           <div class="ebookdownloadinputs">
           <input class="downloadname" type="text" name="downloadname" value="<?php $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );echo esc_html($ebookdownload_lang_name);?>" onfocus="if (this.value == '<?php $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );echo esc_html($ebookdownload_lang_name);?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );echo esc_html($ebookdownload_lang_name);?>';}">
           <input class="downloademail" type="text" name="downloademail" value="<?php $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );echo esc_html($ebookdownload_lang_email);?>" onfocus="if (this.value == '<?php $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );echo esc_html($ebookdownload_lang_email);?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );echo esc_html($ebookdownload_lang_email);?>';}">
           <p style='display:none'><label for="message"><?php echo 'Message'; ?><br />
           <input type="text" name="message" id="message" class="input" value="<?php echo esc_attr(stripslashes($message)); ?>" size="25" /></label></p>
           <input type="hidden" name="ebookdownloadform">   
           <input type="submit" class="downloademailsubmit button" name="submit" value="<?php $ebookdownload_lang_download = get_option( 'ebookdownload_lang_download' );echo esc_html($ebookdownload_lang_download)?>">
           </div>   
</form>
 <?php
  } else {
$downloademail = sanitize_email($_POST['downloademail']);
$downloadname = sanitize_text_field($_POST['downloadname']);

if($downloademail){

global $wpdb;
    $table_name = $wpdb->prefix . 'emaillist'; // do not forget about tables prefix

    $wpdb->insert($table_name, array(
        'name' => "$downloadname",
        'email' => "$downloademail"
    ));
    
echo "<center><strong>";
$ebookdownload_lang_thankyou = get_option( 'ebookdownload_lang_thankyou' );
echo esc_html($ebookdownload_lang_thankyou);
echo "</strong></center>";

echo "<center><a href='$ebookdownloadurl'><strong>";
$ebookdownload_lang_downloadmessage = get_option( 'ebookdownload_lang_downloadmessage' );
echo esc_html($ebookdownload_lang_downloadmessage);
echo "</strong></a></center>";

    if($ebookdownloadurl){   
    $path = parse_url($ebookdownloadurl, PHP_URL_PATH);  
        $file_name = basename($path); 

        echo $link = "<script>window.open('$ebookdownloadurl')</script>";
    }
}else{
?>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>" class="ebookdownloadform">
                    </div>
                <div class="ebookdownloadinputs">
           <input class="downloadname" type="text" name="downloadname" value="<?php echo $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );?>" onfocus="if (this.value == '<?php echo $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );?>';}">
           <input class="downloademail" type="text" name="downloademail" value="<?php echo $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );?>" onfocus="if (this.value == '<?php echo $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );?>';}">
           <p style='display:none'><label for="message"><?php echo 'Message';?><br />
           <input type="text" name="message" id="message" class="input" value="<?php echo esc_attr(stripslashes($message)); ?>" size="25" /></label></p>
           <input type="hidden" name="ebookdownloadform">   
           <input type="submit" class="downloademailsubmit button" name="submit" value="<?php echo $ebookdownload_lang_download = get_option( 'ebookdownload_lang_download' );?>">
           </div>   
</form>    

<?php
echo "<center><strong>";
echo $ebookdownload_lang_emailenterwrong = get_option( 'ebookdownload_lang_emailenterwrong' );
echo "</strong></center>";
}
}
}else{
?>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>" class="ebookdownloadform">
                    </div>
                <div class="ebookdownloadinputs">
           <input class="downloadname" type="text" name="downloadname" value="<?php $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );echo esc_html($ebookdownload_lang_name);?>" onfocus="if (this.value == '<?php $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );echo esc_html($ebookdownload_lang_name);?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php $ebookdownload_lang_name = get_option( 'ebookdownload_lang_name' );echo esc_html($ebookdownload_lang_name);?>';}">
           <input class="downloademail" type="text" name="downloademail" value="<?php $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );echo esc_html($ebookdownload_lang_email);?>" onfocus="if (this.value == '<?php $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );echo esc_html($ebookdownload_lang_email);?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php $ebookdownload_lang_email = get_option( 'ebookdownload_lang_email' );echo esc_html($ebookdownload_lang_email);?>';}">
           <p style='display:none'><label for="message"><?php echo 'Message';?><br />
           <input type="text" name="message" id="message" class="input" value="<?php echo esc_attr(stripslashes($message)); ?>" size="25" /></label></p>
           <input type="hidden" name="ebookdownloadform">   
           <input type="submit" class="downloademailsubmit button" name="submit" value="<?php $ebookdownload_lang_download = get_option( 'ebookdownload_lang_download' );echo esc_html($ebookdownload_lang_download);?>">
           </div>   
</form>

<?php
}
?>
                
                <?php endwhile; ?>
                </div>
                <?php echo $args['after_widget']; ?>
                <?php
                wp_reset_postdata();
            endif;
        }

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_ebook_download', $cache, 'widget' );
        }
        else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['posttype'] = strip_tags( $new_instance['posttype'] );
        $instance['number'] = (int) $new_instance['number'];

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset( $alloptions['widget_ebook_download'] ) ) {
            delete_option( 'widget_ebook_download' );
        }

        return $instance;
    }

    public function flush_widget_cache() {
        wp_cache_delete( 'widget_ebook_download', 'widget' );
    }

    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $posttype = isset( $instance['posttype'] ) ? $instance['posttype']: 'post';
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 1;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
                <input name="<?php echo $this->get_field_name( 'posttype' ); ?>" id="<?php echo $this->get_field_id( 'posttype' ); ?>" value="ebookdownload" type="hidden">
        </p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo 'Number of ebooks to show:'; ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
}