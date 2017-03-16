<?php global $wordchef; ?>
<div class="social-share">

        <?php if ( isset($wordchef['share_checkbox']['1']) && $wordchef['share_checkbox']['1'] == 1 ) { ?>
                <!-- Facebook -->
                <a class="share-facebook" href="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>&amp;t=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>" target="_blank">
                <i class="fa fa-facebook"></i>
                </a> 
        <?php } 
        if ( isset($wordchef['share_checkbox']['2']) && $wordchef['share_checkbox']['2'] == 1 ) { ?>
                <!-- Twitter -->
                <a class="share-twitter" href="http://twitter.com/home/?status=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>%20-%20<?php esc_url( the_permalink() ); ?>" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
        <?php }
        if ( isset($wordchef['share_checkbox']['3']) && $wordchef['share_checkbox']['3'] == 1 ) { ?>
                <!-- Pinterest -->
                <a class="share-pinterest" href="http://pinterest.com/pin/create/button/?url=<?php esc_url( the_permalink() ); ?>&media=<?php $url = esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ); echo esc_url( $url ); ?>" target="_blank">
                    <i class="fa fa-pinterest"></i>
                </a>
        <?php }
        if ( isset($wordchef['share_checkbox']['4']) && $wordchef['share_checkbox']['4'] == 1 ) { ?>
                <!-- Google + -->
                <a class="share-googleplus" href="https://plus.google.com/share?url=<?php esc_url( the_permalink() ); ?>" target="_blank">
                    <i class="fa fa-google-plus"></i>
                </a>    
        <?php } 
        if ( isset($wordchef['share_checkbox']['5']) && $wordchef['share_checkbox']['5'] == 1 ) { ?>
                <!-- Reddit -->
                <a class="share-reddit" href="http://www.reddit.com/submit?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>" target="_blank">
                    <i class="fa fa-reddit"></i>
                </a>
        <?php } 
        if ( isset($wordchef['share_checkbox']['6']) && $wordchef['share_checkbox']['6'] == 1 ) { ?>
                <!-- Digg -->
                <a class="share-digg" href="http://digg.com/submit?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>" target="_blank">
                    <i class="fa fa-digg"></i>
                </a>
        <?php } 
        if ( isset($wordchef['share_checkbox']['7']) && $wordchef['share_checkbox']['7'] == 1 ) { ?>
                <!-- Delicious -->
                <a class="share-delicious" href="http://del.icio.us/post?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>" target="_blank">
                    <i class="fa fa-delicious"></i>
                </a>
        <?php } 
        if ( isset($wordchef['share_checkbox']['8']) && $wordchef['share_checkbox']['8'] == 1 ) { ?>
                <!-- StumbleUpon -->
                <a class="share-stumbleupon" href="http://www.stumbleupon.com/submit?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>" target="_blank">
                    <i class="fa fa-stumbleupon"></i>
                </a>
        <?php } 
        if ( isset($wordchef['share_checkbox']['9']) && $wordchef['share_checkbox']['9'] == 1 ) { ?>
                <!-- Linked In -->
                <a class="share-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>&amp;url=<?php esc_url( the_permalink() ); ?>" target="_blank">
                    <i class="fa fa-linkedin"></i>
                </a>
        <?php }
        if ( isset($wordchef['share_checkbox']['10']) && $wordchef['share_checkbox']['10'] == 1 ) { ?>
                <!-- Mail -->
                <a class="share-mail" href="mailto:?subject=<?php echo rawurlencode(html_entity_decode(get_the_title())); ?>&amp;body=<?php esc_url( the_permalink() ) ?>">
                    <i class="fa fa-envelope-o"></i>
                </a>
        <?php } ?>

</div> <!-- .share -->