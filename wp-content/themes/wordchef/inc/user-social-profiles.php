<?php 
function modify_user_contact_methods( $user_contact ) {

	// Add user contact methods
    $user_contact['facebook']    = esc_html__( 'Facebook URL', 'wordchef' );
	$user_contact['twitter']     = esc_html__( 'Twitter URL', 'wordchef' );
    $user_contact['pinterest']   = esc_html__( 'Pinterest URL', 'wordchef' );
    $user_contact['instagram']   = esc_html__( 'Instagram URL', 'wordchef' );
    $user_contact['tumblr']      = esc_html__( 'Tumblr URL', 'wordchef' );
    $user_contact['google_plus'] = esc_html__( 'Google+ URL', 'wordchef' );
    $user_contact['linkedin']    = esc_html__( 'LinkedIn URL', 'wordchef' );
    $user_contact['youtube']     = esc_html__( 'YouTube URL', 'wordchef' );
    $user_contact['vimeo']       = esc_html__( 'Vimeo URL', 'wordchef' );

	return $user_contact;
}
add_filter( 'user_contactmethods', 'modify_user_contact_methods' );