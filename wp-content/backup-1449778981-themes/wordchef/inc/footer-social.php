<?php global $wordchef; ?>
<div class="footer-social">
    <?php if ( !empty($wordchef['footer-facebook']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-facebook']); ?>" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-twitter']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-twitter']); ?>" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-pinterest']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-pinterest']); ?>" target="_blank" class="pinterest"><i class="fa fa-pinterest"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-instagram']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-instagram']); ?>" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-tumblr']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-tumblr']); ?>" target="_blank" class="tumblr"><i class="fa fa-tumblr"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-google-plus']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-google-plus']); ?>" target="_blank" class="google-plus"><i class="fa fa-google-plus"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-linkedin']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-linkedin']); ?>" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-youtube']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-youtube']); ?>" target="_blank" class="youtube"><i class="fa fa-youtube"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-vimeo']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-vimeo']); ?>" target="_blank" class="vimeo"><i class="fa fa-vimeo-square"></i></a>
    <?php } ?>
    <?php if ( !empty($wordchef['footer-rss']) ) { ?>
        <a href="<?php echo esc_url($wordchef['footer-rss']); ?>" target="_blank" class="rss"><i class="fa fa-rss"></i></a>
    <?php } ?>
</div>