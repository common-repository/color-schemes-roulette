<?php
/**
 * Plugin Name: Color Schemes Roulette
 * Description: Randomly changes the admin color scheme every time you publish a post.
 * Version: 0.7
 * Author: Konstantin Kovshenin
 * Author URI: http://kovshenin.com
 */

function color_schemes_roulette( $new_status, $old_status ) {
	if ( 'publish' != $new_status || 'publish' == $old_status || ! is_user_logged_in() )
		return;

	$color_schemes = array_keys( $GLOBALS['_wp_admin_css_colors'] );
	shuffle( $color_schemes );

	$current = get_user_option( 'admin_color' );
	$chosen = $current;

	while ( $current == $chosen && ! empty( $color_schemes ) )
		$chosen = array_pop( $color_schemes );

	if ( $chosen != $current )
		update_user_meta( get_current_user_id(), 'admin_color', $chosen );
}
add_action( 'transition_post_status', 'color_schemes_roulette', 10, 2 );